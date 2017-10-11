<?php

namespace http\content;

use closure;
use http\response;


class handler
{
    private $check, $converter = null;

    public function __construct ( closure $check, closure $converter )
    {
        $this->check = $check;
        $this->converter = $converter;
    }

    public function canHandle ( $content ) : bool
    {
        return call_user_func ( $this->check, $content );
    }

    public function handle ( $content, response $response ) : response
    {
        return call_user_func ( $this->converter, $content, $response );
    }
}
