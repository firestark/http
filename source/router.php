<?php

namespace http;

use closure;


class router
{
	use \accessible;

	protected $routes = [ ];

	public function add ( route $route )
	{
		if ( $this->has ( $route->uri ) )
			throw new \runtimeException ( "A route for: $route->uri already exists." );

        $this->routes [ $route->uri ] = $route;
	}

	public function has ( string $uri ) : bool
	{
		return array_key_exists ( $uri, $this->routes );
	}

    public function modify ( route $route )
    {
        if ( ! $this->has ( $route->uri ) )
            throw new \runtimeException ( "A route for: $uri does not exist." );

        $this->routes [ $route->uri ] = $route;
    }
}
