<?php

namespace http;


class exception
{
	use \accessible;

	private $status = 500;

	public function __construct ( int $status )
	{
		$this->status = $status;
	}
}