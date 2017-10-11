<?php

namespace http;


class exceptions
{
	private $handlers = [ ];

	public function __construct ( array $handlers = [ ] )
	{
		$this->handlers = $handlers;
	}

	public function add ( int $status, closure $handler )
	{
		if ( $this->has ( $status ) )
			throw new \runtimeException ( "A kernel exception handler for status: {$status} is already defined." );

		$this->handlers [ $status ] = $handler;
	}

	public function handle ( int $status, request $request ) : response
	{
		if ( ! $this->has ( $status ) )
			throw new \runtimeException ( "A kernel exception handler for status: {$status} is not defined." );

		return $this->handlers [ $status ] ( $request );
	}
}