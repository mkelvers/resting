<?php

use Comet\Request;
use Comet\Response;

$app->get('/', function (Request $request, Response $response) {
  $data = ['message' => 'rest api is working!'];
  return $response->with($data);
});
