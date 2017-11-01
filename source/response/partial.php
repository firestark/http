<?php

namespace http\response;


class partial
{
    use \accessible;
    use \http\headers;

	private $data = null;
    private $status = 200;

	public function __construct ( $data, int $status = 200, array $headers = [ ] )
	{
		$this->data = $data;
		$this->status = $status;
		$this->headers = $headers;
	}
}
