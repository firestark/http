<?php

namespace http\response;


class partial
{
    use \http\headers;
    
	public $content = null;
    public $status = 200;

    public function __construct ( $content = '', int $status = 200, array $headers = [ ] )
    {
    	$this->content = $content;
    	$this->status = $status;
    	$this->headers = $headers;
    }
}
