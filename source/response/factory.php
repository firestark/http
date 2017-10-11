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

	public function notFound ( $content ) : partial
	{
		return new partial ( $content, 404 );
	}

	public function conflict ( $content ) : partial
	{
		return new partial ( $content, 409 );
	}
}
