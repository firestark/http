<?php

$string = '[ invoice, office ]';

var_dump ( preg_match ( '/\[.*\]/', $string ) );

$removed = ( str_replace ( [ '[', ']' ], '', $string ) );


var_dump ( explode ( ',', $removed ) );
