<?php

use App\Database;
use function App\rest;
use Comet\Request;
use Comet\Response;

$app->get('/posts', function (Request $request, Response $response) {

    $posts = Database::instance()
        ->query('SELECT * FROM posts')
        ->fetchAll();

    return $response->with(rest($posts, 'posts'));
});

$app->get('/posts/{id}', function (Request $request, Response $response, $args = []) {
    $id = $args['id'];

    $post = Database::instance()
        ->query('SELECT * FROM posts WHERE id = :id', ['id' => $id])
        ->fetch();

    if (!$post) {
        return $response->with(['message' => 'Post not found'], 404);
    }

    return $response->with($post, 200);
});
