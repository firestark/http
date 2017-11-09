<?php

namespace http;


class exception extends \exception implements \is\readable
{
	use \accessible;
	use \readable

	private $status = 500;
	private $message = '';

	public function __construct ( int $status, string $message )
	{
		$this->status = $status;
		$this->message = $message;
	}
}