<?php

use http\app;
use http\content\handler;
use http\content\handlers;
use http\kernel;
use http\request;
use http\response;
use http\response\partial;
use http\router;
use Mockery as mockery;

require __DIR__ . '/../../../vendor/autoload.php';

$app = mockery::mock ( app::class );
$app->shouldReceive ( 'call' )->andReturn ( new partial ( 'Toekan' ) );


$router = new router;
$handlers = new handlers;
$kernel = new kernel ( $app, $router, $handlers );


// content handlers .....

$handlers->add ( new handler (

function ( $content ) : bool
{
    return is_string ( $content );
},
function ( string $content, response $response ) : response
{
    $response->content ( $content );
    return $response;
} ) );


$handlers->add ( new handler (

function ( $content ) : bool
{
    return ( $content instanceOf partial );
},
function ( partial $partial, response $response ) use ( $handlers ): response
{
    $response->status ( ( $partial->status ) ?: 201 );
    return $handlers->handle ( $partial->data, $response );
} ) );


// routes...

$router->add ( 'GET /', function ( )
{
    return new partial ( 'Toekan' );
} );

$response = $kernel->handle ( new request ( '/' ) );
dd ( $response );
