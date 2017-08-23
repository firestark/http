<?php

namespace http;

use closure;
use http\exceptions\routeAlreadyExistsException;
use http\response\preflight;

class router
{
	use \accessible;
	
	private $routes = [ ];

	public function add ( string $uri, closure $action )
	{
		list ( $method, $path ) = explode ( ' ', $uri );
		if ( $this->has ( $method, $path ) )
			throw new routeAlreadyExistsException ( $uri );
		$this->routes [ $method ] [ $path ] = $action;
		$this->addOption ($method,  $path );
	}

	public function has ( string $method, string $path ) : bool
	{
		return ( isset ( $this->routes [ $method ] ) and
			array_key_exists ( $path, $this->routes [ $method ] ) );
	}

	private function addOption ( string $method, string $path )
	{
		( ! $this->has ( 'OPTIONS', $path ) ) ?
			$this->createOption ( $method, $path ) :
			$this->addOptionMethod ( $method, $path );
	}

	private function createOption ( string $method, string $path )
	{
		$this->routes [ 'OPTIONS' ] [ $path ] = function ( ) use ( $method )
		{
			$response = new preflight;
			$response->allowedMethod ( 'OPTIONS' );
			$response->allowedMethod ( $method );
			return $response;
		};
	}

	private function addOptionMethod ( string $method, string $path )
	{
		$response = $this->routes [ 'OPTIONS' ] [ $path ] ( );
		$this->routes [ 'OPTIONS' ] [ $path ] = function ( ) use ( $response, $method )
		{
			$response->allowedMethod ( $method );
			return $response;
		};
	}
}