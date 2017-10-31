<?php

namespace http;

use closure;


class route
{
	use \accessible;

	private $uri = '';
	private $path = '';
	private $method = '';
	private $task = null;
    private $isDynamic = false;

	public function __construct ( string $uri, closure $task )
	{
		list ( $method, $path ) = explode ( ' ', $uri );

		$this->uri = $uri;
		$this->path = $path;
		$this->method = $method;
		$this->task = $task;

        $this->isDynamic = ( strpos ( $uri, '{' ) !== false );
	}
}
