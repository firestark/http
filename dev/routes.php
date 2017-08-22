<?php

$app->route ( 'GET /', function ( )
{

} );


$dispatcher = new http\dispatcher ( $app [ 'routes' ] );
$kernel = new http\kernel ( $dispatcher ); 