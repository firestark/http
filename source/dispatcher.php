<?php

namespace http;

use closure;
use FastRoute\DataGenerator\GroupCountBased as generator;
use FastRoute\Dispatcher\GroupCountBased as base;
use FastRoute\RouteCollector as router;
use FastRoute\RouteParser\Std as parser;
use http\exceptions\methodNotAllowedException;
use http\exceptions\notFoundException;

class dispatcher extends base
{
	private $router = null;

	public function __construct ( array $routes )
	{
		$this->router = new router (
		  	new parser,
		  	new generator
		);

		foreach ( $routes as $method => $route )
			foreach ( $route as $uri => $task )
				$this->add ( $method, $uri, $task );

		parent::__construct ( $this->router->getData ( ) );
	}

	private function add ( string $method, string $uri, closure $task )
	{
		$this->router->addRoute ( $method, $uri, $task );
	}

	public function match ( string $uri )
	{
		list ( $method, $path ) = explode ( ' ', $uri );
		$result = parent::dispatch ( $method, $path );
		return $this->handle ( $result, $method, $path );
	}

	private function decoded ( array $arguments ) : array
    {
        foreach ( $arguments as $key => $value )
            $return [ $key ] = urldecode ( $value );
        return ( $return ) ?? [ ];
    }

	private function handle ( array $result, string $method, string $path ) : array
	{
		if ( $result [ 0 ] === 1 )
			return [ $result [ 1 ], $this->decoded ( $result [ 2 ] ) ];

		if ( $result [ 0 ] === 2 )
			throw new methodNotAllowedException ( $method, $path );
		if ( $result [ 0 ] === 1 )
			throw new notFoundException ( $method, $path );
	}
}