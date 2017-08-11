<?php

namespace http\response;

use closure;
use http\content\handler;
use http\exceptions\cantHandleTypeException;

class factory
{
	/**
	 * An array of content handlers.
	 * @var array
	 */
	private $handlers = [ ];

	/**
	 * The default headers to use when generating a response.
	 * @var array
	 */
	private $headers = [ ];

	public function __construct ( array $handlers = [ ], array $headers = [ ] )
	{
		foreach ( $handlers as $handler )
			$this->handle ( $handler );

		foreach ( $headers as $key => $value )
			$this->header ( $key, $value );
	}

	public function handle ( handler $handler )
	{
		$this->handlers [ ] = $handler;
	}

	public function header ( string $key, string $value )
	{
		$this->headers [ $key ] = $value;
	}

	public function ok ( $content ) : \http\response
	{
		return $this->generate ( $content, 200 );
	}

	public function created ( $content ) : \http\response
	{
		return $this->generate ( $content, 201 );
	}

	public function notFound ( $content ) : \http\response
	{
		return $this->generate ( $content, 404 );
	}

	public function conflict ( $content ) : \http\response
	{
		return $this->generate ( $content, 409 );
	}

	private function generate ( $content, int $status ) : \http\response
	{
		foreach ( $this->handlers as $handler )
			if ( $handler->canHandle ( $content ) )
				return $handler->handle ( $content,
					new \http\response ( '', $status, $this->headers ) );

		throw new cantHandleTypeException ( $type );
	}
}
