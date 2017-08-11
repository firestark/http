<?php

namespace http\exceptions;

class cantHandleTypeException extends \exception
{
	public function __construct ( string $type )
	{
		$this->message = "Type: $type could not be handled. Did you define a handler for it?";
	}
}