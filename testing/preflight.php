<?php

require __DIR__ . '/../vendor/autoload.php';


$preflight = new http\response\preflight;
$preflight->allowedMethod ( 'GET' );
dd ( $preflight );