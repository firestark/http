<?php

namespace http\response;

use http\response;

class preflight extends response
{
	public function __construct ( string $content = '', int $status = 200, array $headers = [ ] )
	{
		parent::__construct ( $content, $status, $headers );
		$this->allowedMethod ( 'OPTIONS' );
	}

	public function allowedMethod ( string $method )
	{
		( ! isset ( $this [ 'Access-Control-Allow-Methods' ] ) ) ?
			$this [ 'Access-Control-Allow-Methods' ] = $method :
			$this->addAllowedMethod ( $method );
	}

	private function addAllowedMethod ( string $method )
	{
		if ( ! in_array ( $method, explode ( ', ', $this [ 'Access-Control-Allow-Methods' ] ) ) )
			$this [ 'Access-Control-Allow-Methods' ] .= ", $method";
	}
}