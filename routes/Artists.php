<?php

use App\Controllers\ArtistController;

$controller = new ArtistController();

$app->get('/artists', [$controller, 'index']);
$app->get('/artists/{id}', [$controller, 'show']);
$app->post('/artists', [$controller, 'store']);
$app->delete('/artists/{id}', [$controller, 'destroy']);