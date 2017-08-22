<?php

namespace http\exceptions;

class routeAlreadyExistsException extends \exception
{
	public function __construct ( string $uri )
	{
		$this->message = "A route for: $uri already exists.";
	}
}