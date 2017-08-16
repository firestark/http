<?php

namespace http;

class middlewares
{
    use \accessible;

    private $stack = [ ];

    public function add ( string $key, closure $action )
    {
        $this->stack [ $key ] = $action;
    }

    public function hasNext ( ) : bool
    {
        return ( count ( $this->stack ) !< 2 );
    }

    public function next ( )
    {
        list ( $action ) = array_slice ( $this->stack, 1, 1 );
        return $action;
    }

    public function run ( request $request, closure $next ) : closure
    {
        $action = array_shift ( $this->stack );
        return $action ( $request, $next );
    }
}
