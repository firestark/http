<?php

namespace http\response;

use closure;
use http\exceptions\cantHandleTypeException;

class factory
{
	/**
	 * An associative array of how to convert a specific type to a string.
	 * The keys are the type to convert to string,
	 * the values are closure which do the conversion.
	 *
	 * @example [ 'array' => function ( array $content, \http\response $response ) 
	 * { 
	 * 		$response [ 'Content-Type'] = 'application/json'; 
	 * 		$response->content ( json_encode ( $content ) ); 
	 * } ]
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
		foreach ( $handlers as $type => $handler )
			$this->handle ( $type, $handler );

		foreach ( $headers as $key => $value )
			$this->header ( $key, $value );
	}

	public function handle ( string $type, closure $handler )
	{
		$this->handlers [ $type ] = $handler;
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

	private function canHandle ( string $type ) : bool
	{
		return array_key_exists ( $type, $this->handlers );
	}

	private function generate ( $content, int $status ) : \http\response
	{
		$type = gettype ( $content );

		if ( ! $this->canHandle ( $type ) )
			throw new cantHandleTypeException ( $type );

		$response = new \http\response ( '', $status, $this->headers );
		return $this->handlers [ $type ] ( $content, $response );
	}
}