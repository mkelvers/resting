<?php

declare(strict_types=1);

use App\Authentication;
use App\Controllers\GenresController;
use App\Database;

$controller = new GenresController(Database::instance());

$app->get('/genres', [$controller, 'index']);
$app->post('/genres', [$controller, 'store'])->add([Authentication::class, 'basicAuth']);;
$app->delete('/genres/{id}', [$controller, 'destroy'])->add([Authentication::class, 'basicAuth']);;
