<?php

namespace http;

use accessible;
use arrayaccess;


class response implements arrayaccess
{
	use accessible;
	use headers;

	protected $status = 200;
	protected $content = '';

	public function __construct ( $content = '', int $status = 200, array $headers = [ ] )
	{
		$this->content = $this->prepare ( $content );
		$this->status = $status;

		$this->headers = array_merge ( $this->headers,$headers );
	}

	public function send ( )
	{
		foreach ( $this->headers as $key => $value )
			header ( "$key: $value" );
		http_response_code ( $this->status );
		echo $this->content;
	}

	protected function prepare ( $content ) : string
	{
		if ( ! is_string ( $content ) && null !== $content && ! is_numeric ( $content ) 
			&& ! is_callable ( array ( $content, '__toString' ) ) )
            throw new \invalidArgumentException (
            	sprintf ( 'The Response content must be a string or object implementing __toString(), "%s" given.', gettype ( $content ) ) );

        return ( string ) $content;
	}
}