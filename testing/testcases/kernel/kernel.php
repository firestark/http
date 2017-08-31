<?php

use http\content\handler;
use http\content\handlers;
use http\app;
use http\dispatcher;
use http\kernel;
use http\middlewares;
use http\request;
use http\response;
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

$app = Mockery::mock ( app::class );
$app->shouldReceive ( 'call' )->andReturn ( 'hello world' );
$handlers = new handlers;
$handlers->add ( new handler (

function ( $content ) : bool
{
    return is_string ( $content );
},

function ( string $content, response $response ) : response
{
    $response->content ( json_encode ( [ 'message' => $content ] ) );
    return $response;
} ) );

$middlewares = new middlewares;


$kernel = new kernel ( $app, $dispatcher, $handlers, $middlewares, 
	'/firestark/framework/http/testing/testcases/kernel/kernel.php' );

$response = $kernel->handle ( request::capture ( ) );
$response->send ( );