<?php

try
{
	$response = $app [ 'kernel' ]->handle ( $app [ 'request' ] );
	$response->send ( );
}
catch ( http\exceptions\notFoundException $exception )
{
	$response = new http\response ( 'Route not found', 404, [ 'Content-Type' => 'text/plain' ] );
	$response->send ( );
    die;
}
catch ( http\exceptions\methodNotAllowedException $exception )
{
    $response = new http\response ( $exception->getMessage ( ), 405, [ 'Content-Type' => 'text/plain' ] );
    $response->send ( );
    die;
}
catch ( agreementexception $exception )
{
    $response = new http\response ( $exception->getMessage ( ), 400, [ 'Content-Type' => 'text/plain' ] );
    $response->send ( );
    die;
}
