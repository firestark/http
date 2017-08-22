<?php

namespace http\exceptions;

class notFoundException extends \exception
{
	public function __construct ( string $method, string $path )
	{
		$this->message = "A route for '{$method} {$path}' can not be found.";
	}
}