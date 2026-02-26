<?php

declare(strict_types=1);

namespace App\Controllers\Records;

use App\Database;
use Comet\Request;
use Comet\Response;

use function App\error_response;

class TracksController
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function store(Request $request, Response $response, array $args): Response
    {
        $record_id = (int)$args['id'];
        if ($record_id <= 0) {
            return $response->with(error_response('invalid record id'), 400);
        }

        $body = $request->getParsedBody();
        $title = $body['title'] ?? null;

        if (!$title) {
            return $response->with(error_response('title is required'), 400);
        }

        $record = $this->db->query('SELECT id FROM records WHERE id = :id', ['id' => $record_id])->fetch();
        if (!$record) {
            return $response->with(error_response('record not found'), 404);
        }

        $sql = 'INSERT INTO tracks (title, duration, position, side, record_id) VALUES (:title, :duration, :position, :side, :record_id)';
        $params = [
            'title' => $title,
            'duration' => $body['duration'] ?? null,
            'position' => $body['position'] ?? null,
            'side' => $body['side'] ?? null,
            'record_id' => $record_id,
        ];

        $this->db->query($sql, $params);

        return $response->with(['message' => 'track created successfully'], 201);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $record_id = (int)$args['id'];
        $track_id = (int)$args['track_id'];

        if ($record_id <= 0 || $track_id <= 0) {
            return $response->with(error_response('invalid record or track id'), 400);
        }

        $body = $request->getParsedBody();
        if (empty($body)) {
            return $response->with(error_response('no data provided'), 400);
        }

        $track = $this->db->query('SELECT id FROM tracks WHERE id = :id AND record_id = :record_id', ['id' => $track_id, 'record_id' => $record_id])->fetch();
        if (!$track) {
            return $response->with(error_response('track not found for this record'), 404);
        }

        $allowedFields = ['title', 'duration', 'position', 'side'];
        $updates = [];
        $params = ['id' => $track_id];

        foreach ($allowedFields as $field) {
            if (array_key_exists($field, $body)) {
                $updates[] = "$field = :$field";
                $params[$field] = $body[$field];
            }
        }

        if (empty($updates)) {
            return $response->with(error_response('no valid fields provided'), 400);
        }

        $sql = 'UPDATE tracks SET ' . implode(', ', $updates) . ' WHERE id = :id';
        $this->db->query($sql, $params);

        $updated_track = $this->db->query('SELECT * FROM tracks WHERE id = :id', ['id' => $track_id])->fetch();

        return $response->with($updated_track, 200);
    }

    public function destroy(Request $request, Response $response, array $args): Response
    {
        $record_id = (int)$args['id'];
        $track_id = (int)$args['track_id'];

        if ($record_id <= 0 || $track_id <= 0) {
            return $response->with(error_response('invalid record or track id'), 400);
        }

        $track = $this->db->query('SELECT id FROM tracks WHERE id = :id AND record_id = :record_id', ['id' => $track_id, 'record_id' => $record_id])->fetch();
        if (!$track) {
            return $response->with(error_response('track not found for this record'), 404);
        }

        $this->db->query('DELETE FROM tracks WHERE id = :id', ['id' => $track_id]);

        return $response->with(null, 204);
    }
}
