<?php

namespace Hypoid\Lavacharts\Exceptions;

class InvalidDataTable extends LavaException
{
    public function __construct($InvalidDataTable = null)
    {
        $message = gettype($InvalidDataTable) . ' is not a valid DataTable.';

        parent::__construct($message);
    }
}
