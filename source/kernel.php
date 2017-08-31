<?php

namespace http;

use closure;
use http\content\handlers;

class kernel
{
    use \accessible;

    private $app, $dispatcher, $handlers, $middlewares = null;
    private $baseUri = '';

    public function __construct ( app $app, dispatcher $dispatcher,
        handlers $handlers, middlewares $middlewares, $baseUri = '' )
    {
        $this->app = $app;
        $this->dispatcher = $dispatcher;
        $this->handlers = $handlers;
        $this->middlewares = $middlewares;
        $this->baseUri = $baseUri;
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
        	$uri = str_replace ( $this->baseUri, '', ( string ) $request );
        	$uri = rtrim ( $uri, '/' ) . '/';
        	
            list ( $task, $arguments ) = $this->dispatcher->match ( $uri );
            $content = $this->app->call ( $task, $arguments );

            return $this->handlers->handle ( $content );
        };
    }
}
