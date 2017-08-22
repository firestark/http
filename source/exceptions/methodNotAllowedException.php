<?php

namespace http\exceptions;

class methodNotAllowedException extends \exception
{
	public function __construct ( string $method, string $path )
	{
		$this->message = "The method: $method is not allowed for path: $path";
	}
}