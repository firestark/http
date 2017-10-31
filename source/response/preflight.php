<?php

namespace http\response;

use http\response;


class preflight extends response
{
    private $allowedMethods = [ ];

	public function __construct ( string $content = '', int $status = 200, array $headers = [ ] )
	{
		parent::__construct ( $content, $status, $headers );
        $this [ 'Access-Control-Allow-Methods' ] = 'OPTIONS';
	}

	public function allowedMethod ( string $method )
	{
        if ( in_array ( $method, $this->allowedMethods ) )
            return;

        $this->allowedMethods [ ] = $method;
        $this [ 'Access-Control-Allow-Methods' ] .= ', ' . $method;
	}
}
