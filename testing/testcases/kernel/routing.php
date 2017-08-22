<?php

use http\dispatcher;
use http\router;

require __DIR__ . '/../../../vendor/autoload.php';


$router = new router;
$router->add ( 'GET /', function ( )
{
	return 'Hello world';
} );

$router->add ( 'POST /', function ( )
{
	return 'Posted';
} );

// dd ( $router->routes );

$dispatcher = new dispatcher ( $router->routes ); 
dd ( $dispatcher->match ( 'OPTIONS /' ) [ 0 ] ( ) );