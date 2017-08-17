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
