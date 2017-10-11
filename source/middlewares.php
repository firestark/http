<?php

namespace http;


class middlewares
{
    use \accessible;

    private $stack = [ ];

    public function add ( middleware $middleware )
    {
        $this->stack [ ] = $middleware;
    }

    public function run ( request $request ) : response
    {
        $this->order ( );
        return $this->stack [ 0 ]->run ( $request );
    }

    private function order ( )
    {
        foreach ( $this->stack as $middleware )
            if ( ( $next = next ( $this->stack ) ) !== false )
                $middleware->preceding ( $next );
    }
}
