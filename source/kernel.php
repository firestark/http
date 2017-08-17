<?php

namespace http;

use closure;
use http\content\handlers;

class kernel
{
    use \accessible;

    private $app, $router, $handlers, $middlewares = null;

    public function __construct ( app $app, router $router,
        handlers $handlers, middlewares $middlewares )
    {
        $this->app = $app;
        $this->router = $router;
        $this->handlers = $handlers;
        $this->middlewares = $middlewares;
    }

    public function handle ( request $request ) : response
    {
        $dispatch = new middleware ( 'responding to the client', $this->dispatch ( ) );
        $this->middlewares->add ( $dispatch );

        return $this->middlewares->run ( $request );
    }

    private function dispatch ( ) : closure
    {
        $this->router->ready ( );

        return function ( request $request ) : response
        {
            $content = $this->app->call (
                $this->router->match ( ( string ) $request ) );

            return $this->handlers->handle ( $content );
        };
    }
}
