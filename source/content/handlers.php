<?php

namespace http\content;

use http\exceptions\cantHandleTypeException;
use http\response;

class handlers
{
    private $handlers = [ ];

    public function add ( handler $handler )
    {
        $this->handlers [ ] = $handler;
    }

    public function handle ( $content, response $response = null ) : response
	{
		foreach ( $this->handlers as $handler )
			if ( $handler->canHandle ( $content ) )
				return $handler->handle ( $content,
					$response ?: ( new response ( '', 200, [ ] ) ) );
		throw new cantHandleTypeException ( gettype ( $content ) );
	}
}
