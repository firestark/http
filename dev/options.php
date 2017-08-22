<?php

class router
{
	public function add ( string $uri, closure $action )
	{
		list ( $method, $uri ) = explode ( ' ', $key );
		$preflight = $this->option ( $uri, $method );
		$this->routes->addRoute ( $method, $uri, $task );
	}

	private function option ( string $uri, string $method )
	{
		if ( ! $this->has ( "OPTIONS $uri" ) )
			return $this->createPreflight ( $uri, $method );

		return $this->extendPreflight ( $uri, $method );
	}

	private function createPreflight ( string $uri, string $method )
	{
		$this->add ( "OPTIONS $uri", function ( ) use ( $method ) : preflightResponse
		{
			$response = new preflightResponse;
			$response->allowsMethod ( $method );
			return $response;
		} );
	}

	private function extendPreflight ( string $uri, string $method )
	{
		$response = $this->match ( "OPTIONS $uri" );

		$this->add ( "OPTIONS $uri", function ( ) use ( $response, $method )
		{
			$response->allowsMethod ( $method );
			return $response;
		} );
	}
}

$dispatcher->option ( '/packages', function ( $response )
{
	$response->allowsMethod ( 'GET' );
} );