<?php

namespace http\exceptions;


class wrongContentTypeException extends \runtimeException
{
	public function __construct ( string $provided, string $expected )
	{
		$this->message = "The content type: `{$provided}` can not be handled, expected: `{$expected}`.";
	}
}