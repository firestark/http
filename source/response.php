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

	public function __construct ( string $content = '', int $status = 200, array $headers = [ ] )
	{
		$this->content = $content;
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
}