<?php

declare(strict_types=1);

use App\Controllers\ProductController;
use App\Database;

$controller = new ProductController(Database::instance());

$app->get('/products', [$controller, 'index']);
$app->get('/products/{id}', [$controller, 'show']);
$app->post('/products', [$controller, 'store']);
$app->put('/products/{id}', [$controller, 'update']);
$app->patch('/products/{id}', [$controller, 'patch']);
$app->delete('/products/{id}', [$controller, 'destroy']);
