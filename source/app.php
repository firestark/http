<?php

namespace http;

use closure;

interface app
{
    public function call ( $task, array $parameters = [ ] );
}
