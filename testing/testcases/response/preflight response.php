<?php

use http\preflightResponse;

require __DIR__ . '/../../../vendor/autoload.php';

$response = new preflightResponse;
$response->allowedMethod ( 'GET' );

dd ( $response );