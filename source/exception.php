<?php

namespace http;


class exception extends \exception
{
	use \accessible;

	private $status = 500;

	public function __construct ( int $status )
	{
		$this->status = $status;
	}
}