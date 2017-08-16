<?php


private $handlers = [ ];

private function generate ( $content, int $status ) : partial
{
    $response = $this->create ( $content );
    $response->status ( $status );

    foreach ( $this->headers as $key => $value )
        $response [ $key ] = $value;

    return $response;
}

private function create ( $content )
{
    if ( $content instanceOf \http\response )
        return $content;
    return $this->transform ( $content );
}

private function transform ( $content ) : \http\response
{
    foreach ( $this->handlers as $handler )
        if ( $handler->canHandle ( $content ) )
            return $handler->handle ( $content,
                new \http\response ( '', 200, [ ] ) );
    throw new cantHandleTypeException ( gettype ( $content ) );
}
