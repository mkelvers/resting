<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;
use function App\error_response;
use function App\paginate;
use Comet\Request;
use Comet\Response;

class GenresController
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function index(Request $request, Response $response): Response
    {
        ['limit' => $limit, 'offset' => $offset] = paginate($request);

        $total = (int)$this->db->query('SELECT COUNT(*) as count FROM genres')->fetch()['count'];

        $genres = $this->db
            ->query(
                'SELECT id, name FROM genres ORDER BY id ASC
                 LIMIT :limit OFFSET :offset',
                ['limit' => $limit, 'offset' => $offset]
            )
            ->fetchAll();

        return $response->with([
            'count' => $total,
            'limit' => $limit,
            'offset' => $offset,
            'results' => $genres,
        ], 200);
    }

    public function store(Request $request, Response $response): Response
    {
        $body = $request->getParsedBody();
        $name = $body['name'] ?? null;

        if (!$name) {
            return $response->with(error_response('name is required'), 400);
        }

        $exists = $this->db
            ->query('SELECT id FROM genres WHERE name = :name', ['name' => $name])
            ->fetch();

        if ($exists) {
            return $response->with(error_response('genre already exists'), 409);
        }

        $this->db->query('INSERT INTO genres (name) VALUES (:name)', ['name' => $name]);
        $id = $this->db->lastInsertId();

        return $response->with(['id' => (int)$id, 'name' => $name], 201);
    }

    public function destroy(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];

        $exists = $this->db
            ->query('SELECT id FROM genres WHERE id = :id', ['id' => $id])
            ->fetch();

        if (!$exists) {
            return $response->with(error_response('genre not found'), 404);
        }

        $this->db->query('DELETE FROM genres WHERE id = :id', ['id' => $id]);

        return $response->with(["message" => "genre deleted"], 204);
    }
}
