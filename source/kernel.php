<?php

namespace http;

use closure;
use http\content\handlers;
use http\exceptions\kernelException;


class kernel
{
    use \accessible;

    private $app, $dispatcher, $handlers, $middlewares = null;

    public function __construct ( app $app, dispatcher $dispatcher,
        handlers $handlers, middlewares $middlewares, exceptions $exceptions )
    {
        $this->app = $app;
        $this->dispatcher = $dispatcher;
        $this->handlers = $handlers;
        $this->middlewares = $middlewares;
        $this->exceptions = $exceptions;
    }

    public function handle ( request $request ) : response
    {
        $dispatch = new middleware ( 'dispatching the request', $this->dispatch ( ) );
        $this->middlewares->add ( $dispatch );

        try {
        	return $this->middlewares->run ( $request );
        }
        catch ( KernelException $exception )
        {
        	return $this->exceptions->handle ( $exception->status, $request );
        }
    }

    private function dispatch ( ) : closure
    {
        return function ( request $request ) : response
        {
            list ( $task, $arguments ) = $this->dispatcher->match ( ( string ) $request );
            $content = $this->app->call ( $task, $arguments );
            return $this->handlers->handle ( $content );
        };
    }
}
