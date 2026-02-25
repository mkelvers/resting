<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;
use Comet\Request;
use Comet\Response;
use function App\rest;
use function App\paginate;
use function App\validate_enum_fields;
use function App\response;
use function App\error_response;

class ProductController
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function index(Request $request, Response $response): Response
    {
        ['limit' => $limit, 'offset' => $offset] = paginate($request);

        $total = (int)$this->db->query('SELECT COUNT(*) as count FROM products')->fetch()['count'];

        $products = $this->db
            ->query('SELECT id FROM products LIMIT :limit OFFSET :offset', ['limit' => $limit, 'offset' => $offset])
            ->fetchAll();

        return $response->with(rest($products, 'products', $total, $limit, $offset));
    }

    public function show(Request $request, Response $response, array $args = []): Response
    {
        $id = filter_var($args['id'], FILTER_VALIDATE_INT);

        if ($id === false || $id <= 0) {
            return $response->with(error_response('invalid product id'), 400);
        }

        $rels = fn(string $sql) => $this->db->query($sql, ['id' => $id])->fetchAll();

        $product = $this->db
            ->query(
                'SELECT p.id, p.title, p.description, p.price, p.media_condition,
                 p.sleeve_condition, p.stock, p.format, p.release_date, c.name as country
                 FROM products p LEFT JOIN country c ON p.country_id = c.id WHERE p.id = :id',
                ['id' => $id]
            )
            ->fetch();

        if (!$product) {
            return $response->with(error_response('product not found'), 404);
        }

        $product['images'] = $this->db->related('images', 'product_id', $id, 'id, url, alt_text');
        $product['artists'] = $rels('SELECT a.id, a.name FROM artist a JOIN product_artists pa ON a.id = pa.artist_id WHERE pa.product_id = :id');
        $product['labels'] = $rels('SELECT l.id, l.name FROM label l JOIN product_labels pl ON l.id = pl.label_id WHERE pl.product_id = :id');
        $product['genres'] = $rels('SELECT g.id, g.name FROM genre g JOIN product_genres pg ON g.id = pg.genre_id WHERE pg.product_id = :id');
        $product['tracks'] = $rels('SELECT title, duration, position, side FROM tracks WHERE product_id = :id ORDER BY side, position');
        $product['credits'] = $rels('SELECT a.name, pc.role FROM product_credits pc JOIN artist a ON pc.artist_id = a.id WHERE pc.product_id = :id');

        return $response->with(response($product));
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

        $sql = 'INSERT INTO products (title, description, price, media_condition, sleeve_condition, stock, format, release_date, country_id) 
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

        return $response->with(response(['message' => 'product created', 'id' => $id], 201), 201);
    }

    public function update(Request $request, Response $response, array $args = []): Response
    {
        $id = filter_var($args['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            return $response->with(error_response('invalid product id'), 400);
        }

        $body = $request->getParsedBody();

        if (!isset($body['title']) || !isset($body['price'])) {
            return $response->with(error_response('title and price are required for replacement'), 400);
        }

        if ($error = validate_enum_fields($body)) {
            return $response->with(error_response($error), 400);
        }

        $product = $this->db->query('SELECT id FROM products WHERE id = :id', ['id' => $id])->fetch();
        if (!$product) {
            return $response->with(error_response('product not found'), 404);
        }

        $sql = 'UPDATE products SET 
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

        return $response->with(response(['message' => 'product updated']));
    }

    public function patch(Request $request, Response $response, array $args = []): Response
    {
        $id = filter_var($args['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            return $response->with(error_response('invalid product id'), 400);
        }

        $body = $request->getParsedBody();
        if (empty($body)) {
            return $response->with(error_response('no data provided'), 400);
        }

        if ($error = validate_enum_fields($body)) {
            return $response->with(error_response($error), 400);
        }

        $product = $this->db->query('SELECT id FROM products WHERE id = :id', ['id' => $id])->fetch();
        if (!$product) {
            return $response->with(error_response('product not found'), 404);
        }

        $allowedFields = [
            'title', 'description', 'price', 'media_condition',
            'sleeve_condition', 'stock', 'format', 'release_date', 'country_id'
        ];

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

        $sql = 'UPDATE products SET ' . implode(', ', $updates) . ' WHERE id = :id';
        $this->db->query($sql, $params);

        return $response->with(response(['message' => 'product updated']));
    }

    public function destroy(Request $request, Response $response, array $args = []): Response
    {
        $id = filter_var($args['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            return $response->with(error_response('invalid product id'), 400);
        }

        $product = $this->db->query('SELECT id FROM products WHERE id = :id', ['id' => $id])->fetch();
        if (!$product) {
            return $response->with(error_response('product not found'), 404);
        }

        $this->db->query('DELETE FROM products WHERE id = :id', ['id' => $id]);

        return $response->with(response(['message' => 'product deleted']));
    }
}
