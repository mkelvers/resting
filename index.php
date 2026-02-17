<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

use Comet\Request;
use Comet\Response;

$app = new Comet\Comet([
    'host' => '127.0.0.1',
    'port' => $_ENV['PORT'],
]);

$app->get('/', function (Request $request, Response $response) {        
    $data = ["message" => "rest api is working!"];
    return $response->with($data);
});

$app->run();