<?php

use http\request;

require __DIR__ . '/../../../vendor/autoload.php';

$request = new request ( '/', 'GET', 
[ 
	'name' => '1 liter bottle', 
	'measurements' => 
	[
		'unit' => 'liter'
	]
] );

dd ( $request->get ( 'measurements.quantity' ) );