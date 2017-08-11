<?php

use http\response;
use http\response\factory;

require __DIR__ . '/../../../../vendor/autoload.php';


$handlers = 
[ 
	'array' 	=> function ( array $content, response $response ) 
	{ 
		$response [ 'Content-Type' ] = 'application/json';
		$response->content ( json_encode ( $content ) );
		
		return $response;
	},
	'string'	=> function ( string $content, response $response )
	{
		$response [ 'Content-Type' ] = 'text/plain';
		$response->content ( $content );

		return $response;
	} 
];

$headers =
[
	'X-Status' => 1
];

$response = new factory ( $handlers, $headers );
( $response->created ( [ 'name' => 'Aron' ] ) )->send ( );