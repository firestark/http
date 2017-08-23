<?php

namespace http\exceptions;

class routeDoesNotExistException extends \exception
{
	public function __construct ( string $uri )
	{
		$this->message = "A route for: $uri does not exist.";
	}
}