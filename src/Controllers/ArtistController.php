<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;
use Comet\Request;
use Comet\Response;

use function App\paginate;
use function App\rest;
use function App\response;
use function App\error_response;

class ArtistController
{
    private string $baseUrl;
    private Database $db;

    public function __construct(Database $db, string $baseUrl)
    {
        $this->db = $db;
        $this->baseUrl = $baseUrl;
    }

    public function index(Request $request, Response $response): Response
    {
        ['limit' => $limit, 'offset' => $offset] = paginate($request);

        $total = (int)$this->db->query('SELECT COUNT(*) as count FROM artist')->fetch()['count'];

        $artists = $this->db
            ->query('SELECT id, name FROM artist LIMIT :limit OFFSET :offset', ['limit' => $limit, 'offset' => $offset])
            ->fetchAll();

        return $response->with(rest($artists, 'artists', $total, $limit, $offset, ['name']));
    }

    public function show(Request $request, Response $response, array $args = []): Response
    {
        $id = filter_var($args['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            return $response->with(error_response('invalid artist id', 400), 400);
        }

        $artist = $this->db->query('SELECT id, name FROM artist WHERE id = :id', ['id' => $id])->fetch();
        if (!$artist) {
            return $response->with(error_response('artist not found', 404), 404);
        }

        $products = $this->db->query(
            'SELECT p.id, p.title FROM products p JOIN product_artists pa ON p.id = pa.product_id WHERE pa.artist_id = :id',
            ['id' => $id]
        )->fetchAll();

        $artist['products'] = array_map(fn($product) => [
            'id' => $product['id'],
            'title' => $product['title'],
            'url' => $this->baseUrl . '/products/' . $product['id'],
        ], $products);

        $credits = $this->db->query(
            'SELECT pc.role, pc.product_id, p.title FROM product_credits pc JOIN products p ON pc.product_id = p.id WHERE pc.artist_id = :id',
            ['id' => $id]
        )->fetchAll();

        $groupedCredits = [];
        foreach ($credits as $credit) {
            $productId = $credit['product_id'];
            if (!isset($groupedCredits[$productId])) {
                $groupedCredits[$productId] = [
                    'product_id' => $productId,
                    'title' => $credit['title'],
                    'url' => $this->baseUrl . '/products/' . $productId,
                    'roles' => [],
                ];
            }
            $groupedCredits[$productId]['roles'][] = $credit['role'];
        }
        $artist['credits'] = array_values($groupedCredits);

        return $response->with(response($artist));
    }

    public function store(Request $request, Response $response): Response
    {
        $body = $request->getParsedBody();

        if (!isset($body['name']) || empty($body['name'])) {
            return $response->with(error_response('name is required', 400), 400);
        }

        $this->db->query('INSERT INTO artist (name) VALUES (:name)', ['name' => $body['name']]);
        $id = (int)$this->db->lastInsertId();

        return $response->with(response(['message' => 'artist created', 'id' => $id], 201), 201);
    }

    public function patch(Request $request, Response $response, array $args = []): Response
    {
        $id = filter_var($args['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            return $response->with(error_response('invalid artist id'), 400);
        }

        $body = $request->getParsedBody();

        if (!isset($body['name']) || empty($body['name'])) {
            return $response->with(error_response('name is required'), 400);
        }

        $artist = $this->db->query('SELECT id FROM artist WHERE id = :id', ['id' => $id])->fetch();
        if (!$artist) {
            return $response->with(error_response('artist not found'), 404);
        }

        $this->db->query('UPDATE artist SET name = :name WHERE id = :id', ['name' => $body['name'], 'id' => $id]);

        return $response->with(response(['message' => 'artist updated']));
    }

    public function destroy(Request $request, Response $response, array $args = []): Response
    {
        $id = filter_var($args['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            return $response->with(error_response('invalid artist id'), 400);
        }

        $artist = $this->db->query('SELECT id FROM artist WHERE id = :id', ['id' => $id])->fetch();
        if (!$artist) {
            return $response->with(error_response('artist not found'), 404);
        }

        $this->db->query('DELETE FROM artist WHERE id = :id', ['id' => $id]);

        return $response->with(response(['message' => 'artist deleted']));
    }
}
