<?php

namespace http;

if ( ! function_exists ( 'getallheaders' ) )
{
    function getallheaders ( )
    {
       	$headers = [ ];
       	foreach ( $_SERVER as $name => $value )
           if ( substr ( $name, 0, 5 ) === 'HTTP_' )
               $headers [ str_replace ( ' ', '-', ucwords (
               		strtolower ( str_replace ( '_', ' ', substr ( $name, 5 ) ) ) ) ) ] = $value;
       return $headers;
    }
}

if ( ! function_exists ( 'parameters' ) )
{
    function parameters ( string $mime = '' ) : array
    {
    	switch ( $mime ) {
    		case 'application/json':
                $input = file_get_contents ( 'php://input' );
    			if ( empty ( $input ) )
                    return [ ];
                $decoded = json_decode ( $input, true );
                if ( $decoded === null )
    				throw new \exception ( 'Invalid JSON supplied.' );
    			return $decoded;
    		default:
    			return $_REQUEST;
    	}
    }
}

if ( ! function_exists ( 'parse_url_array' ) )
{
    function parse_url_array ( string $value ) : array
    {
		$removed = str_replace ( [ '[', ']' ], '', $value );
		return explode ( ',', $removed );
    }
}