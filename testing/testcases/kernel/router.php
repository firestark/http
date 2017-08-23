<?php

use http\route;
use http\router;
use http\response\preflight;

require __DIR__ . '/../../../vendor/autoload.php';


$router = new router;

// dont trigger events in events?

// events -------------------------------------------------------------------------

$router->before ( 'adding a route', function ( route $route )
{
	if ( $route->method === 'OPTIONS' )
		throw new \exception ( 'You may not manually set an options route' );
} );

// adding a method to an existing options route
$router->after ( 'adding a route', 

function ( route $route, router $router )
{
	if ( ! $router->has ( 'OPTIONS ' . $route->path ) )
		return;

	$response = ( $router->match ( 'OPTIONS ' . $route->path )->action ) ( );
	$router->overwrite ( new route ( 'OPTIONS ' . $route->path, function ( ) use ( $response, $route )
	{
		$response->allowedMethod ( $route->method );
		return $response;
	} ), false ); // false for dont notify
} );


// adding a new options route
$router->after ( 'adding a route', 

function ( route $route, router $router )
{
	if ( $router->has ( 'OPTIONS ' . $route->path ) )
		return;

	$router->add ( new route ( 'OPTIONS ' . $route->path, function ( ) use ( $route )
	{
		$response = new preflight;
		$response->allowedMethod ( $route->method );
		return $response;
	} ), false ); // false for dont notify
} );


// --------------------------------------------------------------------------------

$router->add ( new route ( 'GET /', function ( )
{
	return 'Hello world';
} ) );

$router->add ( new route ( 'POST /', function ( )
{
	return 'Hello world';
} ) );

$router->add ( new route ( 'DELETE /', function ( )
{
	return 'Hello world';
} ) );

// $router->add ( new route ( 'OPTIONS /', function ( )
// {
// 	return 'Hello world';
// } ) );

// dd ( $router );
dump ( ( $router->match ( 'OPTIONS /' )->action ) ( ) );
dump ( ( $router->match ( 'GET /' )->action ) ( ) );