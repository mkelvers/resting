<?php

declare(strict_types=1);

use App\Authentication;
use App\Controllers\LabelsController;
use App\Database;

$controller = new LabelsController(Database::instance());

$app->get('/labels', [$controller, 'index']);
$app->post('/labels', [$controller, 'store'])->add([Authentication::class, 'basicAuth']);;
$app->delete('/labels/{id}', [$controller, 'destroy'])->add([Authentication::class, 'basicAuth']);;
