<?php

namespace App\Controllers;

use App\Database;
use Comet\Request;
use Comet\Response;

use function App\paginate;
use function App\rest;

class ArtistController
{
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = $_ENV['BASE_URL'];
    }

    public function index(Request $request, Response $response)
    {
        ['limit' => $limit, 'offset' => $offset] = paginate($request);

        $db = Database::instance();
         
        $total = (int)$db->query('SELECT COUNT(*) as count FROM artist')->fetch()['count'];

        $artists = $db
            ->query('SELECT id, name FROM artist LIMIT ? OFFSET ?', [$limit, $offset])
            ->fetchAll();

        return $response->with(rest($artists, 'artists', $total, $limit, $offset, ['name']));
    }

    public function show(Request $request, Response $response, array $args = [])
    {
        $id = filter_var($args['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            return $response->with(['message' => 'invalid artist id'], 400);
        }

        $db = Database::instance();

        $artist = $db->query('SELECT id, name FROM artist WHERE id = ?', [$id])->fetch();
        if (!$artist) {
            return $response->with(['message' => 'artist not found'], 404);
        }

        $products = $db->query(
            'SELECT p.id, p.title FROM products p JOIN product_artists pa ON p.id = pa.product_id WHERE pa.artist_id = ?',
            [$id]
        )->fetchAll();

        $artist['products'] = array_map(fn($product) => [
            'id' => $product['id'],
            'title' => $product['title'],
            'url' => $this->baseUrl . '/products/' . $product['id'],
        ], $products);

        $credits = $db->query(
            'SELECT pc.role, pc.product_id, p.title FROM product_credits pc JOIN products p ON pc.product_id = p.id WHERE pc.artist_id = ?',
            [$id]
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

        return $response->with($artist);
    }

    public function store(Request $request, Response $response)
    {
        $body = $request->getParsedBody();

        if (!isset($body['name']) || empty($body['name'])) {
            return $response->with(['message' => 'name is required'], 400);
        }

        $db = Database::instance();
        $db->query('INSERT INTO artist (name) VALUES (?)', [$body['name']]);
        $id = \App\Database::pdo()->lastInsertId();

        return $response->with(['message' => 'artist created', 'id' => (int)$id], 201);
    }

    public function patch(Request $request, Response $response, array $args = [])
    {
        $id = filter_var($args['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            return $response->with(['message' => 'invalid artist id'], 400);
        }

        $body = $request->getParsedBody();

        if (!isset($body['name']) || empty($body['name'])) {
            return $response->with(['message' => 'name is required'], 400);
        }

        $db = Database::instance();

        $artist = $db->query('SELECT id FROM artist WHERE id = ?', [$id])->fetch();
        if (!$artist) {
            return $response->with(['message' => 'artist not found'], 404);
        }

        $db->query('UPDATE artist SET name = ? WHERE id = ?', [$body['name'], $id]);

        return $response->with(['message' => 'artist updated'], 200);
    }

    public function destroy(Request $request, Response $response, array $args = [])
    {
        $id = filter_var($args['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            return $response->with(['message' => 'invalid artist id'], 400);
        }

        $db = Database::instance();

        $artist = $db->query('SELECT id FROM artist WHERE id = ?', [$id])->fetch();
        if (!$artist) {
            return $response->with(['message' => 'artist not found'], 404);
        }

        $db->query('DELETE FROM artist WHERE id = ?', [$id]);

        return $response->with(['message' => 'artist deleted'], 200);
    }
}