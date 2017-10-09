<?php

namespace http;

use closure;
use http\exceptions\routeAlreadyExistsException;
use http\exceptions\routeDoesNotExistException;


class router
{
	use \accessible;
	
	protected $routes = [ ];

	public function add ( route $route )
	{
		if ( $this->has ( $route->uri ) )
			throw new routeAlreadyExistsException ( $route->uri );
		
		$this->routes [ $route->uri ] = $route;
	}

	public function has ( string $uri ) : bool
	{
		return array_key_exists ( $uri, $this->routes );
	}

	public function match ( string $uri ) : route
	{
		if ( ! $this->has ( $uri ) )
			throw new routeDoesNotExistException ( $uri );
		
		return $this->routes [ $uri ]; 
	}
}