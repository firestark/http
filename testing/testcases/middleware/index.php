<?php

use http\kernel;
use http\middleware;
use http\request;
use http\response;

require __DIR__ . '/../../../vendor/autoload.php';




$kernel = new kernel;

$kernel->middlewares->add ( new middleware ( 'messing with the request',

function ( request $request, middleware $next ) : response
{
    $request [ 'X-QbilTrade-Client' ] = 'marine olie';
    $response = $next ( $request );
    $response [ 'test' ] = 'toekan';

    return $response;
} ) );



$kernel->middlewares->add ( new middleware ( 'telling that it was not found',

function ( request $request, middleware $next ) : response
{
    $request [ 'X-QbilTrade-Client' ] = 'no olie';
    return $next ( $request );
} ) );



$kernel->middlewares->add ( new middleware ( 'overwire',

function ( request $request, middleware $next ) : response
{
    $response = $next ( $request );
    $response->content ( 'OVERWIRED' );
    $response->status ( 404 );
    return $response;
} ) );



$response = $kernel->handle ( request::capture ( ) );
$response->send ( );
