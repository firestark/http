<?php

namespace http\exceptions;


class kernelException extends \runtimeException
{
	private $status = 500;

	public function __construct ( int $status = 500 )
	{
		$this->status = $status;
	}
}