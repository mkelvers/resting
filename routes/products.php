<?php

use App\Controllers\ProductController;

$controller = new ProductController();

$app->get('/products', [$controller, 'index']);
$app->get('/products/{id}', [$controller, 'show']);
$app->post('/products', [$controller, 'store']);
$app->put('/products/{id}', [$controller, 'update']);
$app->patch('/products/{id}', [$controller, 'patch']);
$app->delete('/products/{id}', [$controller, 'destroy']);
