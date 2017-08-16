<?php

namespace http;

use closure;

class kernel
{
    private $middlewares = [ ];

    public function middleware ( string $key, closure $action )
    {
        $this->middlewares [ $key ] = $action;
    }

    public function handle ( request $request ) : response
    {
        foreach ( $this->middlewares as $middleware )
        {
            if ( empty ( next ( $this->middlewares ) ) )
                $next = $this->dispatch ( );
            $response = $middleware ( $request, $next );
        }

        return ( $response ) ?? call_user_func( $this->dispatch ( ), $request );
    }

    private function dispatch ( ) : closure
    {
        return function ( request $request )
        {
            return new response ( $request [ 'X-QbilTrade-Client' ] ?? 'noooooh' );
        };
    }
}
