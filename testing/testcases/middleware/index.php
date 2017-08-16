<?php

use http\kernel;
use http\request;

require __DIR__ . '/../../../vendor/autoload.php';


$kernel = new kernel;
$kernel->middleware ( 'fucking with the request', function ( request $request, closure $next )
{
    $request [ 'X-QbilTrade-Client' ] = 'marine olie';
    return $next ( $request );
} );

$response = $kernel->handle ( request::capture ( ) );
$response->send ( );
