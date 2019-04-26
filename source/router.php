<?php

namespace http;

use closure;
use http\route\group;


class router
{
	use \accessible;

	protected $routes = [ ];
	protected $groups = [ ];
	protected $group = null;

	public function add ( route $route )
	{
		if ( ! is_null ( $this->group ) )
			return $this->group->add ( $route );

		if ( $this->has ( $route->uri ) )
			throw new \runtimeException ( "A route for: {$route->uri} already exists." );

        $this->routes [ $route->uri ] = $route;
	}

	public function has ( string $uri ) : bool
	{
		return array_key_exists ( $uri, $this->routes );
	}

	public function group ( string $uri, closure $routes )
	{
		$this->group = new group ( $uri, $routes );
		$routes ( );
		$this->groups [ ] = $this->group;
		$this->group = null;
	}
}
