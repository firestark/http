<?php

namespace http;

trait headers
{
	protected $headers = [ ];
	
	public function offsetExists ( $header ) : bool
	{
		return isset ( $this->headers [ $header ] );
	}

	public function offsetGet ( $header )
	{
		if ( isset ( $this->headers [ $header ] ) )
			return $this->headers [ $header ];
	}

	public function offsetSet ( $header, $value )
	{
		$this->headers [ $header ] = $value;
	}

	public function offsetUnset ( $header )
	{
		if ( isset ( $this->headers [ $header ] ) )
			unset ( $this->headers [ $header ] );
	}
}