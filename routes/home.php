<?php

use App\Database;
use Comet\Request;
use Comet\Response;

$app->get('/', function (Request $request, Response $response) {

  $posts = Database::instance()
    ->query('SELECT * FROM posts')
    ->fetchAll();

  return $response->with($posts);
});