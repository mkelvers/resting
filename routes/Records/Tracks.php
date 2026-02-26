<?php

declare(strict_types=1);

use App\Controllers\Records\TracksController;
use App\Database;
use App\Authentication;

$controller = new TracksController(Database::instance());

$app->post('/records/{id}/tracks', [$controller, 'store'])->add([Authentication::class, 'basicAuth']);
$app->patch('/records/{id}/tracks/{track_id}', [$controller, 'update'])->add([Authentication::class, 'basicAuth']);
$app->delete('/records/{id}/tracks/{track_id}', [$controller, 'destroy'])->add([Authentication::class, 'basicAuth']);
