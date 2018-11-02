<?php

namespace http\response;

use http\response;


class factory
{
	private $response = '';

	public function __construct ( string $class = response::class )
	{
		$this->response = $class;
	}

	public function ok ( $content = '' )
	{
		return $this->respond ( $content, 200 );
	}

	public function created ( $content )
	{
		return $this->respond ( $content, 201 );
	}

	public function badRequest ( $content = '' )
	{
		$content = ( $content ) ?: 'Bad request.';
		return $this->respond ( $content, 400 );
	}

	public function forbidden ( $content )
	{
		return $this->respond ( $content, 403 );
	}

	public function notFound ( $content )
	{
		return $this->respond ( $content, 404 );
	}

	public function notAllowed ( $content )
	{
		return $this->respond ( $content, 405 );
	}

	public function conflict ( $content )
	{
		return $this->respond ( $content, 409 );
	}

	public function error ( $content )
	{
		return $this->respond ( $content, 500 );
	}

	private function respond ( $content, int $status ) : response
	{
		$response = $this->response;
		return new $response ( $content, $status );
	}
}
