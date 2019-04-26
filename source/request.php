<?php

namespace http;

use accessible;
use arrayaccess;


class request implements arrayaccess
{
	use accessible;
	use headers;

	protected $uri = '/';
	protected $method = 'GET';
	protected $parameters = [ ];
	protected $content = '';

	public function __construct ( string $uri, string $method = 'GET', array $parameters = [ ],
		string $content = '', array $headers = [ ] )
	{
		$this->uri = $uri;
		$this->method = $method;
		$this->parameters = $parameters;
		$this->content = $content;
		$this->headers = $headers;
	}

	public static function capture ( ) : request
	{
		$uri = parse_url ( $_SERVER [ 'REQUEST_URI' ] ) [ 'path' ] ?? '/';
		return new static ( $uri, $_SERVER [ 'REQUEST_METHOD' ],
		parameters ( get_mime_type ( ) ),
			'', getallheaders ( ) );
	}

	public function get ( string $parameter, $default = null )
	{
		return array_get ( $this->parameters, $parameter, $default );
	}

	public function set ( string $parameter, $value )
	{
		$this->parameters [ $parameter ] = $value;
	}

	public function has ( string $parameter ) : bool
	{
		return isset ( $this->parameters [ $parameter ] );
	}

	public function all ( ) : array
	{
		return $this->parameters;
	}

    public function __toString ( ) : string
    {
        return $this->method . ' ' . $this->uri;
    }
}
