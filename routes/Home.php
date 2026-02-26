<?php

declare(strict_types=1);

use Comet\Request;
use Comet\Response;

$app->get('/', function (Request $request, Response $response) {
  return $response->with(['message' => 'hello world'], 200);
});

$app->get('/favicon.ico', function ($request, $response) {
  return $response->withStatus(204);
});
