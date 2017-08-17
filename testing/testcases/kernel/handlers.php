<?php

use http\content\handler;
use http\kernel;
use http\response;
use http\request;


require __DIR__ . '/../../../vendor/autoload.php';


$kernel = new kernel;

$kernel->handlers->add ( new handler ( function ( $content ) : bool
{
	return is_array ( $content );
},

function ( array $content, response $response ) : response
{
	$response->content ( json_encode ( array_values ( $content ) ) );
	return $response;
} ) );


$kernel->handlers->add ( new handler ( function ( $content ) : bool
{
	return ( $content instanceOf response\partial );
},

function ( response\partial $partial, response $response ) use ( $kernel ) : response
{
	$response->status ( $partial->status );
	$response->content ( $kernel->handlers->handle ( $partial->data ) );
	return $response;
} ) );


$response = $kernel->handle ( new request ( '/' ) );
$response->send ( );
