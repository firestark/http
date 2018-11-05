<?php

namespace http\response;

use http\response;


class preflight extends response
{
	protected $headers =
	[
		'Content-Type' 					=> '',
		'Content-Length' 				=> 0,
		'Access-Control-Allow-Methods' 	=> 'OPTIONS',
		'Access-Control-Allow-Headers' 	=> 'Content-Type, Authorization',
		'Access-Control-Allow-Origin'   => '*'
	];

    private $allowedMethods = [ 'OPTIONS' ];

    public function __construct (  )
	{
		// disallowed to set any content, status or headers.
	}

	public function allowedMethod ( string $method )
	{
        if ( in_array ( $method, $this->allowedMethods ) )
            return;

        $this->allowedMethods [ ] = $method;
        $this [ 'Access-Control-Allow-Methods' ] .= ', ' . $method;
	}
}
