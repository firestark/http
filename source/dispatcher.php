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
    private $deffered = [ ];

	public function __construct ( array $routes )
	{
		$this->router = new router (
		  	new parser,
		  	new generator
		);

		foreach ( $routes as $route )
            $this->add ( $route );

        foreach ( $this->deffered as $route )
            $this->router->addRoute ( $route->method, $route->path, $route->task );

		parent::__construct ( $this->router->getData ( ) );
	}

	private function add ( route $route )
	{
        if ( ( strpos ( $route->uri, '{' ) !== false ) )
            $this->deffered [ ] = $route;
        else
            $this->router->addRoute ( $route->method, $route->path, $route->task );
	}

	public function match ( string $uri )
	{
		list ( $method, $path ) = explode ( ' ', $uri );
		$result = parent::dispatch ( $method, $path );
		return $this->handle ( $result, $method, $path );
	}

	protected function notFound ( string $method, string $path )
	{
		throw new exception ( 404 );
	}

	protected function notAllowed ( string $method, string $path )
    {
        throw new exception ( 405 );
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
			$this->notAllowed ( $method, $path );

		if ( $result [ 0 ] === 0 )
			$this->notFound ( $method, $path );
	}
}
