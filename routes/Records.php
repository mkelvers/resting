<?php

declare(strict_types=1);

use App\Controllers\RecordController;
use App\Database;

$controller = new RecordController(Database::instance());

$app->get('/records', [$controller, 'index']);
$app->get('/records/{id}', [$controller, 'show']);
$app->post('/records', [$controller, 'store'])->add([App\Authentication::class, 'basicAuth']);;
$app->put('/records/{id}', [$controller, 'update'])->add([App\Authentication::class, 'basicAuth']);;
$app->patch('/records/{id}', [$controller, 'patch'])->add([App\Authentication::class, 'basicAuth']);;
$app->delete('/records/{id}', [$controller, 'destroy'])->add([App\Authentication::class, 'basicAuth']);;
