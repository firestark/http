<?php

namespace http\route;

use closure;
use http\route;

class group
{
    use \accessible;
    
    private $uri = '';
    private $definition = null;
    private $routes = [ ];

    public function __construct ( string $uri, closure $definition )
    {
        $this->uri = $uri;
        $this->definition = $definition;
    }

    public function add ( route $route )
	{
		if ( $this->has ( $route->uri ) )
			throw new \runtimeException ( "A route for: {$route->uri} already exists." );

        $this->routes [ $route->uri ] = $route;
	}

	public function has ( string $uri ) : bool
	{
		return array_key_exists ( $uri, $this->routes );
    }
}