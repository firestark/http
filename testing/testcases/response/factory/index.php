<?php

use http\content\handler;
use http\response;
use http\response\factory;

require __DIR__ . '/../../../../vendor/autoload.php';


$handlers =
[
	new handler ( function ( $content )
	{
		return is_array ( $content );
	},
	function ( array $content, response $response )
	{
		$response [ 'Content-Type' ] = 'application/json';
		$response->content ( json_encode ( $content ) );

		return $response;
	} )
];

$headers =
[
	'X-Status' => 1
];

$response = new factory ( $handlers, $headers );
( $response->created ( [ 'name' => 'Aron' ] ) )->send ( );
