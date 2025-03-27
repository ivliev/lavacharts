<?php

namespace Hypoid\Lavacharts\Exceptions;

use Hypoid\Lavacharts\Charts\Chart;

class DataTableNotFound extends LavaException
{
    public function __construct(Chart $chart)
    {
        $message = $chart->getType() . '(' . $chart->getLabel() . ') has no DataTable.';

        parent::__construct($message);
    }
}
