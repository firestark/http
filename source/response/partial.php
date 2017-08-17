<?php

namespace http\response;

class partial
{
    use \accessible;

	private $data = null;
    private $status = 200;
    private $headers = [ ];

	public function __construct ( $data, int $code = 200, array $headers = [ ] )
	{
		$this->data = $data;
		$this->code = $code;
		foreach ( $headers as $key => $value )
			$this->header ( $key, $value );
	}

	private function header ( string $key, string $value )
	{
		$this->header [ $key ] = $value;
	}
}
