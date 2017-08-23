<?php

$router->extend ( 'add', function ( route $route, closure $task )
{
	if ( $route->method === 'OPTIONS' )
		throw new \exception ( 'You may not manually set an options route' );

	$task ( );
} );

$router->extend ( 'add', function ( route $route closure $task ) use ( $router )
{
	$task ( );
	
	if ( ! $router->has ( 'OPTIONS ' . $route->path ) )
		return;

	$response = ( $router->match ( 'OPTIONS ' . $route->path )->action ) ( );
	$router->overwrite ( new route ( 'OPTIONS ' . $route->path, function ( ) use ( $response, $route )
	{
		$response->allowedMethod ( $route->method );
		return $response;
	} ), false ); // false for dont notify
} );
