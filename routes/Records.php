<?php

declare(strict_types=1);

use App\Authentication;
use App\Controllers\RecordController;
use App\Database;

$controller = new RecordController(Database::instance());

$app->get('/records', [$controller, 'index']);
$app->get('/records/{id}', [$controller, 'show']);
$app->post('/records', [$controller, 'store'])->add([Authentication::class, 'basicAuth']);;
$app->put('/records/{id}', [$controller, 'update'])->add([Authentication::class, 'basicAuth']);;
$app->patch('/records/{id}', [$controller, 'patch'])->add([Authentication::class, 'basicAuth']);;
$app->delete('/records/{id}', [$controller, 'destroy'])->add([Authentication::class, 'basicAuth']);;
