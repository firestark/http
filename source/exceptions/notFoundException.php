<?php

namespace http\exceptions;

class notFoundException extends \exception
{
	public function __construct ( string $method, string $path )
	{
		$this->message = "A route for '{$method} {$path}' can not be found. 
			did you add a trailing slash to the uri? if so remove it.";
	}
}