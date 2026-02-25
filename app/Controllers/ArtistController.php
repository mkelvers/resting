<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;
use Comet\Request;
use Comet\Response;

use function App\paginate;
use function App\rest;
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

        $total = (int)$this->db->query('SELECT COUNT(*) as count FROM artists')->fetch()['count'];

        $artists = $this->db
            ->query('SELECT id, name FROM artists LIMIT :limit OFFSET :offset', ['limit' => $limit, 'offset' => $offset])
            ->fetchAll();

        return $response->with(rest($artists, 'artists', $total, $limit, $offset, ['name']));
    }

    public function show(Request $request, Response $response, array $args = []): Response
    {
        $id = filter_var($args['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            return $response->with(error_response('invalid artist id'), 400);
        }

        $artist = $this->db->query('SELECT id, name FROM artists WHERE id = :id', ['id' => $id])->fetch();
        if (!$artist) {
            return $response->with(error_response('artist not found'), 404);
        }

        $records = $this->db->query(
            'SELECT p.id, p.title FROM records p JOIN record_artists ra ON p.id = ra.record_id WHERE ra.artist_id = :id',
            ['id' => $id]
        )->fetchAll();

        $artist['records'] = array_map(fn($record) => [
            'id' => $record['id'],
            'title' => $record['title'],
            'url' => $this->baseUrl . '/records/' . $record['id'],
        ], $records);

        $credits = $this->db->query(
            'SELECT rc.role, rc.record_id, p.title FROM record_credits rc JOIN records p ON rc.record_id = p.id WHERE rc.artist_id = :id',
            ['id' => $id]
        )->fetchAll();

        // group credits by record since an artist can have multiple roles on one record
        $groupedCredits = [];
        foreach ($credits as $credit) {
            $recordId = $credit['record_id'];
            if (!isset($groupedCredits[$recordId])) {
                $groupedCredits[$recordId] = [
                    'record_id' => $recordId,
                    'title' => $credit['title'],
                    'url' => $this->baseUrl . '/records/' . $recordId,
                    'roles' => [],
                ];
            }
            $groupedCredits[$recordId]['roles'][] = $credit['role'];
        }
        $artist['credits'] = array_values($groupedCredits);

        return $response->with($artist, 200);
    }

    public function store(Request $request, Response $response): Response
    {
        $body = $request->getParsedBody();

        if (!isset($body['name']) || empty($body['name'])) {
            return $response->with(error_response('name is required'), 400);
        }

        $this->db->query('INSERT INTO artists (name) VALUES (:name)', ['name' => $body['name']]);
        $id = (int)$this->db->lastInsertId();

        return $response->with(['message' => 'artist created', 'id' => $id], 201);
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

        $artist = $this->db->query('SELECT id FROM artists WHERE id = :id', ['id' => $id])->fetch();
        if (!$artist) {
            return $response->with(error_response('artist not found'), 404);
        }

        $this->db->query('UPDATE artists SET name = :name WHERE id = :id', ['name' => $body['name'], 'id' => $id]);

        return $response->with(['message' => 'artist updated']);
    }

    public function destroy(Request $request, Response $response, array $args = []): Response
    {
        $id = filter_var($args['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            return $response->with(error_response('invalid artist id'), 400);
        }

        $artist = $this->db->query('SELECT id FROM artists WHERE id = :id', ['id' => $id])->fetch();
        if (!$artist) {
            return $response->with(error_response('artist not found'), 404);
        }

        $this->db->query('DELETE FROM artists WHERE id = :id', ['id' => $id]);

        return $response->with(['message' => 'artist deleted'], 200);
    }
}
