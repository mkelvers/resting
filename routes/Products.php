<?php

declare(strict_types=1);

use App\Controllers\ProductController;
use App\Database;

$controller = new ProductController(Database::instance());

$app->get('/products', [$controller, 'index']);
$app->get('/products/{id}', [$controller, 'show']);
$app->post('/products', [$controller, 'store'])->add([App\Authentication::class, 'basicAuth']);;
$app->put('/products/{id}', [$controller, 'update'])->add([App\Authentication::class, 'basicAuth']);;
$app->patch('/products/{id}', [$controller, 'patch'])->add([App\Authentication::class, 'basicAuth']);;
$app->delete('/products/{id}', [$controller, 'destroy'])->add([App\Authentication::class, 'basicAuth']);;
