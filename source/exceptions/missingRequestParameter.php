<?php

namespace http\exceptions;

class missingRequestParameter extends \runtimeException
{
	public function __construct ( string $key )
	{
		$this->message = "The parameter `{$key}` is not provided in the request parameters.";
	}
}