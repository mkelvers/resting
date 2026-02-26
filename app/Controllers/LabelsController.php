<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;
use function App\error_response;
use function App\paginate;
use Comet\Request;
use Comet\Response;

class LabelsController
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function index(Request $request, Response $response): Response
    {
        ['limit' => $limit, 'offset' => $offset] = paginate($request);

        $total = (int)$this->db->query('SELECT COUNT(*) as count FROM labels')->fetch()['count'];

        $labels = $this->db
            ->query(
                'SELECT id, name FROM labels ORDER BY id ASC
                 LIMIT :limit OFFSET :offset',
                ['limit' => $limit, 'offset' => $offset]
            )
            ->fetchAll();

        return $response->with([
            'count' => $total,
            'limit' => $limit,
            'offset' => $offset,
            'results' => $labels,
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
            ->query('SELECT id FROM labels WHERE name = :name', ['name' => $name])
            ->fetch();

        if ($exists) {
            return $response->with(error_response('label already exists'), 409);
        }

        $this->db->query('INSERT INTO labels (name) VALUES (:name)', ['name' => $name]);
        $id = $this->db->lastInsertId();

        return $response->with(['id' => (int)$id, 'name' => $name], 201);
    }

    public function destroy(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];

        $exists = $this->db
            ->query('SELECT id FROM labels WHERE id = :id', ['id' => $id])
            ->fetch();

        if (!$exists) {
            return $response->with(error_response('label not found'), 404);
        }

        $this->db->query('DELETE FROM labels WHERE id = :id', ['id' => $id]);

        return $response->with(["message" => "label deleted"], 204);
    }
}
