<?php

use App\Database;
use function App\rest;
use Comet\Request;
use Comet\Response;

// list all products (returns id + url for each)
$app->get('/products', function (Request $request, Response $response) {
    $products = Database::instance()
        ->query('SELECT * FROM products')
        ->fetchAll();

    return $response->with(rest($products, 'products'));
});

// get single product with related data
$app->get('/products/{id}', function (Request $request, Response $response, $args = []) {
    $id = $args['id'];

    // fetch product + country name
    $product = Database::instance()
        ->query(
            'SELECT p.*, c.name as country 
             FROM products p 
             LEFT JOIN country c ON p.country_id = c.id 
             WHERE p.id = :id',
            ['id' => $id]
        )
        ->fetch();

    if (!$product) {
        return $response->with(['message' => 'product not found'], 404);
    }

    unset($product['country_id']);

    // labels
    $product['labels'] = Database::instance()
        ->query(
            'SELECT l.name FROM product_labels pl 
             JOIN label l ON pl.label_id = l.id 
             WHERE pl.product_id = :id',
            ['id' => $id]
        )
        ->fetchAll(\PDO::FETCH_COLUMN);

    // images
    $product['images'] = Database::instance()
        ->query(
            'SELECT url, alt_text FROM images WHERE product_id = :id ORDER BY position',
            ['id' => $id]
        )
        ->fetchAll();

    // artists
    $product['artists'] = Database::instance()
        ->query(
            'SELECT a.name FROM product_artists pa 
             JOIN artist a ON pa.artist_id = a.id 
             WHERE pa.product_id = :id',
            ['id' => $id]
        )
        ->fetchAll(\PDO::FETCH_COLUMN);

    // genres
    $product['genres'] = Database::instance()
        ->query(
            'SELECT g.name FROM product_genres pg 
             JOIN genre g ON pg.genre_id = g.id 
             WHERE pg.product_id = :id',
            ['id' => $id]
        )
        ->fetchAll(\PDO::FETCH_COLUMN);

    // tracks
    $product['tracks'] = Database::instance()
        ->query(
            'SELECT title, duration, position, side 
             FROM tracks 
             WHERE product_id = :id 
             ORDER BY side, position',
            ['id' => $id]
        )
        ->fetchAll();

    // credits
    $product['credits'] = Database::instance()
        ->query(
            'SELECT a.name, pc.role 
             FROM product_credits pc 
             JOIN artist a ON pc.artist_id = a.id 
             WHERE pc.product_id = :id',
            ['id' => $id]
        )
        ->fetchAll();

    return $response->with($product, 200);
});
