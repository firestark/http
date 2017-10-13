<?php

namespace http;

use closure;
use FastRoute\DataGenerator\GroupCountBased as generator;
use FastRoute\Dispatcher\GroupCountBased as base;
use FastRoute\RouteCollector as router;
use FastRoute\RouteParser\Std as parser;
use http\exceptions\kernelException;


class dispatcher extends base
{
	private $router = null;

	public function __construct ( array $routes )
	{
		$this->router = new router (
		  	new parser,
		  	new generator
		);

		foreach ( $routes as $route )
			$this->add ( $route->method, $route->path, $route->task );

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
			throw new exception ( 405 );
		
		if ( $result [ 0 ] === 0 )
			throw new exception ( 404 );
	}
}