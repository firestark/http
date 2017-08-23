<?php

namespace http;

use closure;
use http\exceptions\routeAlreadyExistsException;
use http\exceptions\routeDoesNotExistException;
use http\response\preflight;

class router
{
	use \accessible;
	
	private $routes = [ ];
	private $events = [ ];

	public function add ( route $route, bool $notify = true )
	{
		$this->run ( 'adding a route', $route, function ( ) use ( $route )
		{
			if ( $this->has ( $route->uri ) )
				throw new routeAlreadyExistsException ( $route->uri );
			
			$this->routes [ $route->uri ] = $route;
		}, $notify );
	}

	public function overwrite ( route $route, bool $notify = true )
	{
		$this->run ( 'overwriting a route', $route, function ( ) use ( $route )
		{
			$this->checkExistenceFor ( $route->uri );
			$this->routes [ $route->uri ] = $route;
		}, $notify );
	}

	public function has ( string $uri ) : bool
	{
		return array_key_exists ( $uri, $this->routes );
	}

	public function match ( string $uri ) : route
	{
		$this->checkExistenceFor ( $uri );
		return $this->routes [ $uri ]; 
	}

	public function before ( string $event, closure $action )
	{
		$this->events [ 'before ' . $event ] [ ] = $action;
	}

	public function after ( string $event, closure $action )
	{
		$this->events [ 'after ' . $event ] [ ] = $action;
	}

	private function notify ( string $event, route $route )
	{
		if ( array_key_exists ( $event, $this->events ) )
			foreach ( $this->events [ $event ] as $action )
				if ( $action ( $route, $this ) === false )
					break;
	}

	private function checkExistenceFor ( string $uri )
	{
		if ( ! $this->has ( $uri ) )
			throw new routeDoesNotExistException ( $uri );
	}

	private function run ( string $event, route $route, closure $task, bool $notify = true )
	{
		if ( $notify === true )
			$this->notify ( 'before ' . $event, $route );

		$task ( );

		if ( $notify === true )
			$this->notify ( 'after ' . $event, $route );
	}
}