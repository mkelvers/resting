<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use App\Routes;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = new Comet\Comet([
    'host' => '127.0.0.1',
    'port' => $_ENV['PORT'],
]);

Routes::register($app);

$app->run();