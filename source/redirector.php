<?php

namespace http;

use exception;


class redirector
{
    private $url = '';
    private $previous = '';
    
    public function __construct ( string $url = '', string $previous = '/' )
    {
        $this->url = rtrim ( $url, '/' );
        $this->previous = $previous;
    }
    
    public function to ( string $uri, int $status = 303 ) : response
    {
        return $this->respond ( $this->url . $uri, $status );
    }
    
    public function back ( int $status = 303 ) : response
    {
        if ( $this->previous === '' )
            throw new exception ( 'Can\'t redirect to an empty url, Check if you have specified the previous url in the constructor\'s second argument.' );
        return $this->respond ( $this->previous, $status );
    }

 	public function full ( string $url, int $status = 303 ) : response
    {
        return $this->respond ( $url, $status );
    }
    
    protected function respond ( string $url, int $status ) : response
    {
        $response = new response ( 'Redirecting', $status );
        $response [ 'Location' ] = $url;
        return $response;
    }
}
