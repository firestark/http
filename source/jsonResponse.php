<?php

namespace http;


class jsonResponse extends response
{
	protected $jsonHeaders =
	[
		'Content-Type' => 'application/json',
		'Access-Control-Allow-Headers' => 'Origin, Accept, Content-Type, Authorization, X-Requested-With, Content-Range, Content-Disposition',
	];

    public function __construct ( string $content = '', int $status = 200, array $headers = [ ] )
    {
        $this->headers = array_merge ( $headers, $this->jsonHeaders );
        parent::__construct ( $content, $status, $headers );
    }
}
