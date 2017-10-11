<?php

namespace http;

use closure;


class kernel
{
    public function handle ( request $request )
    {
    	$response = $this->middlewares->handle ( $request );
    }
}
