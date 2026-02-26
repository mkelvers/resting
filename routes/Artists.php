<?php

declare(strict_types=1);

use App\Authentication;
use App\Controllers\ArtistController;
use App\Database;

$controller = new ArtistController(
    Database::instance(),
    (string)$_ENV['BASE_URL']
);

$app->get('/artists', [$controller, 'index']);
$app->get('/artists/{id}', [$controller, 'show']);
$app->post('/artists', [$controller, 'store'])->add([Authentication::class, 'basicAuth']);;
$app->delete('/artists/{id}', [$controller, 'destroy'])->add([Authentication::class, 'basicAuth']);;
