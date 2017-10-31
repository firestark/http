<?php

namespace http;

use http\response\preflight;


class optionsRouter extends router
{
	public function add ( route $route )
	{
		if ( $route->method === 'OPTIONS' )
			throw new \runtimeException ( 'You may not manually set an OPTIONS route.' );

		parent::add ( $route );
		$this->addOption ( $route->method,  $route->path );
	}

	private function addOption ( string $method, string $path )
	{
		$uri = 'OPTIONS ' . $path;

		( ! $this->has ( $uri ) ) ?
			$this->createOption ( $method, $uri ) :
			$this->addOptionMethod ( $method, $uri );
	}

	private function createOption ( string $method, string $uri )
	{
		parent::add ( new route ( $uri, function ( ) use ( $method )
		{
			$response = new preflight;
			$response->allowedMethod ( $method );
			return $response;
		} ) );
	}

	private function addOptionMethod ( string $method, string $uri )
	{
		$response = ( $this->routes [ $uri ]->task ) ( );

		parent::modify ( new route ( $uri, function ( ) use ( $response, $method )
		{
			$response->allowedMethod ( $method );
			return $response;
		} ) );
	}
}
