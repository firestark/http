<?php

namespace http;


class jsonResponse extends response
{
	protected $headers =
	[
		'Content-Type' => 'application/json',
		'Access-Control-Allow-Headers' => 'Origin, Accept, Content-Type, Authorization, X-Requested-With, Content-Range, Content-Disposition',
	];
}