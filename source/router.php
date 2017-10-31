<?php

namespace http;

use closure;


class router
{
	use \accessible;

	protected $routes =
    [
        'static' => [ ],
        'dynamic' => [ ]
    ];

	public function add ( route $route )
	{
		if ( $this->has ( $route->uri ) )
			throw new \runtimeException ( "A route for: $route->uri already exists." );

        ( $route->isDynamic ) ?
            $this->routes [ 'dynamic' ] [ $route->uri ] = $route :
            $this->routes [ 'static' ] [ $route->uri ] = $route;
	}

	public function has ( string $uri ) : bool
	{
		return array_key_exists ( $uri, $this->routes );
	}

	public function match ( string $uri ) : route
	{
		if ( ! $this->has ( $uri ) )
			throw new \runtimeException ( "A route for: $uri does not exist." );

		return $this->routes [ $uri ];
	}
}
