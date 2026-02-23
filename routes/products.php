<?php

use App\Database;
use function App\rest;
use Comet\Request;
use Comet\Response;

$app->get('/products', function (Request $request, Response $response) {
    $products = Database::instance()
        ->query('SELECT * FROM products')
        ->fetchAll();

    return $response->with(rest($products, 'products'));
});

$app->get('/products/{id}', function (Request $request, Response $response, $args = []) {
    $id = filter_var($args['id'], FILTER_VALIDATE_INT);

    if ($id === false || $id <= 0) {
        return $response->with(['message' => 'invalid product id'], 400);
    }

    $db = Database::instance();
    $rels = fn(string $sql) => $db->query($sql, ['id' => $id])->fetchAll();

    $product = $db
        ->query(
            'SELECT p.id, p.title, p.description, p.price, p.media_condition,
             p.sleeve_condition, p.stock, p.format, p.release_date, c.name as country
             FROM products p JOIN country c ON p.country_id = c.id WHERE p.id = :id',
            ['id' => $id]
        )
        ->fetch();

    if (!$product) {
        return $response->with(['message' => 'product not found'], 404);
    }

    $product['images'] = $db->related('images', 'product_id', $id, 'id, url, alt_text');
    $product['artists'] = $rels('SELECT a.id, a.name FROM artist a JOIN product_artists pa ON a.id = pa.artist_id WHERE pa.product_id = :id');
    $product['labels'] = $rels('SELECT l.id, l.name FROM label l JOIN product_labels pl ON l.id = pl.label_id WHERE pl.product_id = :id');
    $product['genres'] = $rels('SELECT g.id, g.name FROM genre g JOIN product_genres pg ON g.id = pg.genre_id WHERE pg.product_id = :id');
    $product['tracks'] = $rels('SELECT title, duration, position, side FROM tracks WHERE product_id = :id ORDER BY side, position');
    $product['credits'] = $rels('SELECT a.name, pc.role FROM product_credits pc JOIN artist a ON pc.artist_id = a.id WHERE pc.product_id = :id');

    return $response->with($product, 200);
});