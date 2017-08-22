<?php

namespace http;

class preflightResponse extends response
{
	public function allowedMethod ( string $method )
	{
		isset ( $this [ 'Access-Control-Allow-Methods' ] ) ?
			$this [ 'Access-Control-Allow-Methods' ] .= ", $method" :
			$this [ 'Access-Control-Allow-Methods' ] = $method;
	}
}