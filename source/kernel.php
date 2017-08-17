<?php

namespace http;

use closure;

class kernel
{
    use \accessible;

    private $middlewares = null;

    public function __construct ( middlewares $middlewares = null )
    {
        $this->middlewares = ( $middlewares ) ?: new middlewares;
    }

    public function handle ( request $request ) : response
    {
        $dispatch = new middleware ( 'responding to the client', $this->dispatch ( ) );
        $this->middlewares->add ( $dispatch );

        return $this->middlewares->run ( $request );
    }

    private function dispatch ( ) : closure
    {
        return function ( request $request ) : response
        {
            $response = new response ( $request [ 'X-QbilTrade-Client' ] ?? 'noooooh' );
            $response [ 'initial' ] = 'initial header';
            return $response;
        };
    }
}
