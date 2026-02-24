<?php

namespace App\Controllers;

use App\Database;
use Comet\Request;
use Comet\Response;
use function App\rest;
use function App\paginate;

class ProductController
{
    /**
     * Retrieve all products.
     * 
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function index(Request $request, Response $response)
    {
        ['limit' => $limit, 'offset' => $offset] = paginate($request);

        $db = Database::instance();

        $total = (int)$db->query('SELECT COUNT(*) as count FROM products')->fetch()['count'];

        $products = $db
            ->query("SELECT id FROM products LIMIT $limit OFFSET $offset")
            ->fetchAll();

        return $response->with(rest($products, 'products', $total, $limit, $offset));
    }

    /**
     * Retrieve a single product by ID, including its related entities.
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args Route arguments (e.g., ['id' => 1])
     * @return Response
     */
    public function show(Request $request, Response $response, array $args = [])
    {
        // ensure the ID provided in the URL is a valid integer
        $id = filter_var($args['id'], FILTER_VALIDATE_INT);

        if ($id === false || $id <= 0) {
            return $response->with(['message' => 'invalid product id'], 400);
        }

        $db = Database::instance();
        
        // helper function to quickly run relationship queries
        $rels = fn(string $sql) => $db->query($sql, ['id' => $id])->fetchAll();

        $product = $db
            ->query(
                'SELECT p.id, p.title, p.description, p.price, p.media_condition,
                 p.sleeve_condition, p.stock, p.format, p.release_date, c.name as country
                 FROM products p LEFT JOIN country c ON p.country_id = c.id WHERE p.id = :id',
                ['id' => $id]
            )
            ->fetch();

        if (!$product) {
            return $response->with(['message' => 'product not found'], 404);
        }

        // fetch related entities. this creates n+1 queries per product
        // but it's fine, it's just for a school project.
        $product['images'] = $db->related('images', 'product_id', $id, 'id, url, alt_text');
        $product['artists'] = $rels('SELECT a.id, a.name FROM artist a JOIN product_artists pa ON a.id = pa.artist_id WHERE pa.product_id = :id');
        $product['labels'] = $rels('SELECT l.id, l.name FROM label l JOIN product_labels pl ON l.id = pl.label_id WHERE pl.product_id = :id');
        $product['genres'] = $rels('SELECT g.id, g.name FROM genre g JOIN product_genres pg ON g.id = pg.genre_id WHERE pg.product_id = :id');
        $product['tracks'] = $rels('SELECT title, duration, position, side FROM tracks WHERE product_id = :id ORDER BY side, position');
        $product['credits'] = $rels('SELECT a.name, pc.role FROM product_credits pc JOIN artist a ON pc.artist_id = a.id WHERE pc.product_id = :id');

        return $response->with($product, 200);
    }

    /**
     * Create a new product.
     * 
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function store(Request $request, Response $response)
    {
        $body = $request->getParsedBody();

        // require at least a title and a price to create a product
        if (!isset($body['title']) || !isset($body['price'])) {
            return $response->with(['message' => 'title and price are required'], 400);
        }

        $db = Database::instance();
        $sql = 'INSERT INTO products (title, description, price, media_condition, sleeve_condition, stock, format, release_date, country_id) 
                VALUES (:title, :description, :price, :media_condition, :sleeve_condition, :stock, :format, :release_date, :country_id)';
        
        // prepare the parameters. We use the coalesce operator (??) to allow optional fields to default to null
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

        $db->query($sql, $params);
        $id = \App\Database::pdo()->lastInsertId();

        return $response->with(['message' => 'product created', 'id' => (int)$id], 201);
    }

    /**
     * Completely update a product.
     * Replaces all fields with the provided values, or null if omitted.
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function update(Request $request, Response $response, array $args = [])
    {
        $id = filter_var($args['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            return $response->with(['message' => 'invalid product id'], 400);
        }

        $body = $request->getParsedBody();

        if (!isset($body['title']) || !isset($body['price'])) {
            return $response->with(['message' => 'title and price are required for replacement'], 400);
        }

        $db = Database::instance();
        
        // verify the product exists before attempting to update it
        $product = $db->query('SELECT id FROM products WHERE id = :id', ['id' => $id])->fetch();
        if (!$product) {
            return $response->with(['message' => 'product not found'], 404);
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
                
        // overwrite every column, similar to the store method
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

        $db->query($sql, $params);

        return $response->with(['message' => 'product updated'], 200);
    }

    /**
     * Partially update a product.
     * Only fields present in the request body will be changed.
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function patch(Request $request, Response $response, array $args = [])
    {
        $id = filter_var($args['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            return $response->with(['message' => 'invalid product id'], 400);
        }

        $body = $request->getParsedBody();
        if (empty($body)) {
            return $response->with(['message' => 'no data provided'], 400);
        }

        $db = Database::instance();
        
        $product = $db->query('SELECT id FROM products WHERE id = :id', ['id' => $id])->fetch();
        if (!$product) {
            return $response->with(['message' => 'product not found'], 404);
        }

        // whitelist of columns that can be modified via PATCH
        $allowedFields = [
            'title', 'description', 'price', 'media_condition', 
            'sleeve_condition', 'stock', 'format', 'release_date', 'country_id'
        ];

        $updates = [];
        $params = ['id' => $id];

        // dynamically build the SET clause by checking which whitelisted fields are in the body
        foreach ($allowedFields as $field) {
            if (array_key_exists($field, $body)) {
                $updates[] = "$field = :$field";
                $params[$field] = $body[$field];
            }
        }

        if (empty($updates)) {
            return $response->with(['message' => 'no valid fields provided'], 400);
        }

        // construct the final query string and execute
        $sql = 'UPDATE products SET ' . implode(', ', $updates) . ' WHERE id = :id';
        $db->query($sql, $params);

        return $response->with(['message' => 'product updated'], 200);
    }

    /**
     * Delete a product.
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function destroy(Request $request, Response $response, array $args = [])
    {
        $id = filter_var($args['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            return $response->with(['message' => 'invalid product id'], 400);
        }

        $db = Database::instance();

        $product = $db->query('SELECT id FROM products WHERE id = :id', ['id' => $id])->fetch();
        if (!$product) {
            return $response->with(['message' => 'product not found'], 404);
        }

        $db->query('DELETE FROM products WHERE id = :id', ['id' => $id]);

        return $response->with(['message' => 'product deleted'], 200);
    }
}
