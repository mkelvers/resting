<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;
use Comet\Request;
use Comet\Response;
use function App\rest;
use function App\paginate;
use function App\validate_enum_fields;
use function App\error_response;

class RecordController
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function index(Request $request, Response $response): Response
    {
        ['limit' => $limit, 'offset' => $offset] = paginate($request);

        $total = (int)$this->db->query('SELECT COUNT(*) as count FROM records')->fetch()['count'];

        $records = $this->db
            ->query('SELECT id FROM records LIMIT :limit OFFSET :offset', ['limit' => $limit, 'offset' => $offset])
            ->fetchAll();

        return $response->with(rest($records, 'records', $total, $limit, $offset));
    }

    public function show(Request $request, Response $response, array $args = []): Response
    {
        $id = filter_var($args['id'], FILTER_VALIDATE_INT);

        if ($id === false || $id <= 0) {
            return $response->with(error_response('invalid record id'), 400);
        }

        // shorthand for running relationship queries
        $rels = fn(string $sql) => $this->db->query($sql, ['id' => $id])->fetchAll();

        $record = $this->db
            ->query(
                'SELECT p.id, p.title, p.description, p.price, p.media_condition,
                 p.sleeve_condition, p.stock, p.format, p.release_date, c.name as country
                 FROM records p LEFT JOIN countries c ON p.country_id = c.id WHERE p.id = :id',
                ['id' => $id]
            )
            ->fetch();

        if (!$record) {
            return $response->with(error_response('record not found'), 404);
        }

        $record['images'] = $this->db->related('images', 'record_id', $id, 'id, url, alt_text');
        $record['artists'] = $rels('SELECT a.id, a.name FROM artists a JOIN record_artists ra ON a.id = ra.artist_id WHERE ra.record_id = :id');
        $record['labels'] = $rels('SELECT l.id, l.name FROM labels l JOIN record_labels rl ON l.id = rl.label_id WHERE rl.record_id = :id');
        $record['genres'] = $rels('SELECT g.id, g.name FROM genres g JOIN record_genres rg ON g.id = rg.genre_id WHERE rg.record_id = :id');
        $record['tracks'] = $rels('SELECT title, duration, position, side FROM tracks WHERE record_id = :id ORDER BY side, position');
        $record['credits'] = $rels('SELECT a.name, rc.role FROM record_credits rc JOIN artists a ON rc.artist_id = a.id WHERE rc.record_id = :id');

        return $response->with($record, 200);
    }

    public function store(Request $request, Response $response): Response
    {
        $body = $request->getParsedBody();

        if (!isset($body['title']) || !isset($body['price'])) {
            return $response->with(error_response('title and price are required'), 400);
        }

        if ($error = validate_enum_fields($body)) {
            return $response->with(error_response($error), 400);
        }

        $sql = 'INSERT INTO records (title, description, price, media_condition, sleeve_condition, stock, format, release_date, country_id) 
                VALUES (:title, :description, :price, :media_condition, :sleeve_condition, :stock, :format, :release_date, :country_id)';

        $params = [
            'title' => $body['title'],
            'description' => $body['description'] ?? null,
            'price' => $body['price'],
            'media_condition' => $body['media_condition'] ?? null,
            'sleeve_condition' => $body['sleeve_condition'] ?? null,
            'stock' => $body['stock'] ?? 0,
            'format' => $body['format'] ?? null,
            'release_date' => $body['release_date'] ?? null,
            'country_id' => $body['country_id'] ?? null,
        ];

        $this->db->query($sql, $params);
        $id = (int)$this->db->lastInsertId();

        return $response->with(['message' => 'record created', 'id' => $id], 201);
    }

    public function update(Request $request, Response $response, array $args = []): Response
    {
        $id = filter_var($args['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            return $response->with(error_response('invalid record id'), 400);
        }

        $body = $request->getParsedBody();

        if (!isset($body['title']) || !isset($body['price'])) {
            return $response->with(error_response('title and price are required for replacement'), 400);
        }

        if ($error = validate_enum_fields($body)) {
            return $response->with(error_response($error), 400);
        }

        $record = $this->db->query('SELECT id FROM records WHERE id = :id', ['id' => $id])->fetch();
        if (!$record) {
            return $response->with(error_response('record not found'), 404);
        }

        $sql = 'UPDATE records SET 
                title = :title, 
                description = :description, 
                price = :price, 
                media_condition = :media_condition, 
                sleeve_condition = :sleeve_condition, 
                stock = :stock, 
                format = :format, 
                release_date = :release_date, 
                country_id = :country_id
                WHERE id = :id';

        $params = [
            'id' => $id,
            'title' => $body['title'],
            'description' => $body['description'] ?? null,
            'price' => $body['price'],
            'media_condition' => $body['media_condition'] ?? null,
            'sleeve_condition' => $body['sleeve_condition'] ?? null,
            'stock' => $body['stock'] ?? 0,
            'format' => $body['format'] ?? null,
            'release_date' => $body['release_date'] ?? null,
            'country_id' => $body['country_id'] ?? null,
        ];

        $this->db->query($sql, $params);

        return $response->with(['message' => 'record updated']);
    }

    public function patch(Request $request, Response $response, array $args = []): Response
    {
        $id = filter_var($args['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            return $response->with(error_response('invalid record id'), 400);
        }

        $body = $request->getParsedBody();
        if (empty($body)) {
            return $response->with(error_response('no data provided'), 400);
        }

        if ($error = validate_enum_fields($body)) {
            return $response->with(error_response($error), 400);
        }

        $record = $this->db->query('SELECT id FROM records WHERE id = :id', ['id' => $id])->fetch();
        if (!$record) {
            return $response->with(error_response('record not found'), 404);
        }

        $allowedFields = [
            'title',
            'description',
            'price',
            'media_condition',
            'sleeve_condition',
            'stock',
            'format',
            'release_date',
            'country_id'
        ];

        // only update fields that were actually sent in the request
        $updates = [];
        $params = ['id' => $id];
        foreach ($allowedFields as $field) {
            if (array_key_exists($field, $body)) {
                $updates[] = "$field = :$field";
                $params[$field] = $body[$field];
            }
        }

        if (empty($updates)) {
            return $response->with(error_response('no valid fields provided'), 400);
        }

        $sql = 'UPDATE records SET ' . implode(', ', $updates) . ' WHERE id = :id';
        $this->db->query($sql, $params);

        return $response->with(['message' => 'record updated']);
    }

    public function destroy(Request $request, Response $response, array $args = []): Response
    {
        $id = filter_var($args['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            return $response->with(error_response('invalid record id'), 400);
        }

        $record = $this->db->query('SELECT id FROM records WHERE id = :id', ['id' => $id])->fetch();
        if (!$record) {
            return $response->with(error_response('record not found'), 404);
        }

        $this->db->query('DELETE FROM records WHERE id = :id', ['id' => $id]);

        return $response->with(['message' => 'record deleted'], 200);
    }
}
