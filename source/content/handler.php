<?php

namespace http\content;

use closure;
use http\response;


class handler
{
    private $check, $handle = null;

    public function __construct ( closure $check, closure $handle )
    {
        $this->check = $check;
        $this->handle = $handle;
    }

    public function canHandle ( $content ) : bool
    {
        return call_user_func ( $this->check, $content );
    }

    public function handle ( $content, response $response ) : response
    {
        return call_user_func ( $this->handle, $content, $response );
    }
}
