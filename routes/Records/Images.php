<?php

declare(strict_types=1);

use App\Controllers\Records\ImagesController;
use App\Database;
use App\Authentication;

$controller = new ImagesController(Database::instance());

$app->post('/records/{id}/images', [$controller, 'store'])->add([Authentication::class, 'basicAuth']);
$app->patch('/records/{id}/images/{image_id}', [$controller, 'update'])->add([Authentication::class, 'basicAuth']);
$app->delete('/records/{id}/images/{image_id}', [$controller, 'destroy'])->add([Authentication::class, 'basicAuth']);
