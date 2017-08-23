<?php

use http\dispatcher;
use http\route;
use http\router;

require __DIR__ . '/../../../vendor/autoload.php';


$router = new router;
$router->add ( new route ( 'GET /', function ( )
{
	return 'Hello world';
} ) );

$router->add ( new route ( 'POST /', function ( )
{
	return 'Posted';
} ) );

$dispatcher = new dispatcher ( $router->routes );
dd ( $dispatcher->match ( 'POST /' ) [ 0 ] ( ) );