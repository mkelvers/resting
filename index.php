<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use App\Routes;

// Only load .env file if environment variables are not already set (e.g., in production)
if (!isset($_ENV['DB_HOST'])) {
  $dotenv = Dotenv::createImmutable(__DIR__);
  $dotenv->safeLoad();
}

$app = new Comet\Comet([
    'host' => '0.0.0.0',
    'port' => $_ENV['PORT'] ?? 8080,
]);

Routes::register($app);

$app->run();