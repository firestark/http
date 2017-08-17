<?php

namespace http;

use closure;

class middleware
{
    use \accessible;

    private $name = '';
    private $task = null;
    private $next = null;

    public function __construct ( string $name, closure $task )
    {
        $this->name = $name;
        $this->task = $task;
    }

    public function preceding ( middleware $next )
    {
        $this->next = $next;
    }

    public function run ( request $request )
    {
        return call_user_func_array ( $this->task, [
            $request,
            $this->next
        ] );
    }

    public function __invoke ( request $request )
    {
        return $this->run ( $request );
    }
}
