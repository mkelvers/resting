<?php

declare(strict_types=1);

namespace App\Controllers\Records;

use App\Database;
use Comet\Request;
use Comet\Response;

use function App\error_response;

class ImagesController
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
        $url = $body['url'] ?? null;

        if (!$url) {
            return $response->with(error_response('url is required'), 400);
        }

        $record = $this->db->query('SELECT id FROM records WHERE id = :id', ['id' => $record_id])->fetch();
        if (!$record) {
            return $response->with(error_response('record not found'), 404);
        }

        $sql = 'INSERT INTO images (url, alt_text, record_id) VALUES (:url, :alt_text, :record_id)';
        $params = [
            'url' => $url,
            'alt_text' => $body['alt_text'] ?? null,
            'record_id' => $record_id,
        ];

        $this->db->query($sql, $params);
        $id = $this->db->lastInsertId();

        $new_image = $this->db->query('SELECT * FROM images WHERE id = :id', ['id' => $id])->fetch();

        return $response->with($new_image, 201);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $record_id = (int)$args['id'];
        $image_id = (int)$args['image_id'];

        if ($record_id <= 0 || $image_id <= 0) {
            return $response->with(error_response('invalid record or image id'), 400);
        }

        $body = $request->getParsedBody();
        if (empty($body)) {
            return $response->with(error_response('no data provided'), 400);
        }

        $image = $this->db->query(
            'SELECT id FROM images WHERE id = :id AND record_id = :record_id',
            ['id' => $image_id, 'record_id' => $record_id]

        )->fetch();
        if (!$image) {
            return $response->with(error_response('image not found for this record'), 404);
        }

        $allowedFields = ['url', 'alt_text'];
        $updates = [];
        $params = ['id' => $image_id];

        foreach ($allowedFields as $field) {
            if (array_key_exists($field, $body)) {
                $updates[] = "$field = :$field";
                $params[$field] = $body[$field];
            }
        }

        if (empty($updates)) {
            return $response->with(error_response('no valid fields provided'), 400);
        }

        $sql = 'UPDATE images SET ' . implode(', ', $updates) . ' WHERE id = :id';
        $this->db->query($sql, $params);

        $updated_image = $this->db->query('SELECT * FROM images WHERE id = :id', ['id' => $image_id])->fetch();

        return $response->with($updated_image, 200);
    }

    public function destroy(Request $request, Response $response, array $args): Response
    {
        $record_id = (int)$args['id'];
        $image_id = (int)$args['image_id'];

        if ($record_id <= 0 || $image_id <= 0) {
            return $response->with(error_response('invalid record or image id'), 400);
        }

        $image = $this->db->query(
            'SELECT id FROM images WHERE id = :id AND record_id = :record_id',
            ['id' => $image_id, 'record_id' => $record_id]
        )->fetch();

        if (!$image) {
            return $response->with(error_response('image not found for this record'), 404);
        }

        $this->db->query('DELETE FROM images WHERE id = :id', ['id' => $image_id]);

        return $response->with(null, 204);
    }
}
