<?php

declare(strict_types=1);

use App\Controllers\ArtistController;
use App\Database;

$controller = new ArtistController(
    Database::instance(),
    (string)$_ENV['BASE_URL']
);

$app->get('/artists', [$controller, 'index']);
$app->get('/artists/{id}', [$controller, 'show']);
$app->post('/artists', [$controller, 'store']);
$app->delete('/artists/{id}', [$controller, 'destroy']);
