<?php

use http\request;



$testcase->blueprint ( 'testing for the correct uri', 

function ( request $request, array $uri )
{
	assertThat ( $request->uri, is ( identicalTo ( $uri [ 'expected' ] ) ) );
} );