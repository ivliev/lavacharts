<?php

namespace Hypoid\Lavacharts\Exceptions;

class ChartNotFound extends LavaException
{
    public function __construct($type, $label)
    {
        $message = "$type('$label') was not found.";

        parent::__construct($message);
    }
}
