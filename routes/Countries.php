<?php

declare(strict_types=1);

use App\Authentication;
use App\Controllers\CountryController;
use App\Database;

$controller = new CountryController(Database::instance());

$app->get('/countries', [$controller, 'index']);
$app->post('/countries', [$controller, 'store'])->add([Authentication::class, 'basicAuth']);;
$app->delete('/countries/{id}', [$controller, 'destroy'])->add([Authentication::class, 'basicAuth']);;
