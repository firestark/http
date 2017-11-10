<?php

namespace http;


class exception extends \exception implements \is\readable
{
	use \accessible;
	use \readable;

	protected $status = 500;
	protected $message = '';

	public function __construct ( int $status, string $message )
	{
		$this->status = $status;
		$this->message = $message;
	}
}