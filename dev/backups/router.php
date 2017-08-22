<?php

namespace http;

use closure;
use FastRoute\DataGenerator\GroupCountBased as generator;
use FastRoute\Dispatcher\GroupCountBased as dispatcher;
use FastRoute\RouteCollector as routes;
use FastRoute\RouteParser\Std as parser;

class router
{
	private $dispatcher, $routes = null;

	public function __construct ( )
	{
		$this->routes = new routes (
		  	new parser,
		  	new generator
		);
	}

	public function add ( string $key, closure $task )
	{
		list ( $method, $uri ) = explode ( ' ', $key );
		$this->option ( $uri, $method );
		$this->routes->addRoute ( $method, $uri, $task );
	}

	public function match ( string $key ) : array
	{
		list ( $method, $uri ) = explode ( ' ', $key );
		$result = $this->dispatcher->dispatch ( $method, $uri );

		return $this->handle ( $result, $key );
	}

	public function ready ( )
	{
		$this->dispatcher = new dispatcher ( $this->routes->getData ( ) );
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

	private function decoded ( array $arguments ) : array
    {
        foreach ( $arguments as $key => $value )
            $return [ $key ] = urldecode ( $value );
        return ( $return ) ?? [ ];
    }

	private function handle ( array $result, string $key ) : array
	{
		if ( $result [ 0 ] === 1 )
			return [ $result [ 1 ], $this->decoded ( $result [ 2 ] ) ];

		throw new \exception ( "A route for: $key could not be found." );
	}
}
