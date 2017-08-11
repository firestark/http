<?php


$testcase->add ( 'testing for the correct uri', function ( )
{
	$uri = '//hello//world//';
	$request = mockery::mock ( http\request::class, [ $uri ] );

	return [ $uri, [ 'expected' => '/hello/world', 'given' => $uri ] ];
} );