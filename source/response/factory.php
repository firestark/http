<?php

namespace http\response;

use closure;


class factory
{
	public function ok ( $content = null ) : partial
	{
		if ( $content === null )
			return new partial ( $content, 204 );

		return new partial ( $content, 200 );
	}

	public function created ( $content ) : partial
	{
		return new partial ( $content, 201 );
	}

	public function badRequest ( $content = '' ) : partial
	{
		$content = ( $content ) ?: 'Bad request.';
		return new partial ( $content, 400 );
	}

	public function notFound ( $content ) : partial
	{
		return new partial ( $content, 404 );
	}

	public function notAllowed ( $content ) : partial
	{
		return new partial ( $content, 405 );
	}

	public function conflict ( $content ) : partial
	{
		return new partial ( $content, 409 );
	}

	public function error ( $content ) : partial
	{
		return new partial ( $content, 500 );
	}
}
