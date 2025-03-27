<?php

namespace Hypoid\Lavacharts\Exceptions;

use Hypoid\Lavacharts\Charts\ChartFactory;

class InvalidChartType extends LavaException
{
    public function __construct($invalidChart)
    {
        $badChart = (string) $invalidChart;

        $message  = "'$badChart' is not a valid chart type, must be one of ";
        $message .= '[ ' . implode(' | ', ChartFactory::getChartTypes()) . ']';

        parent::__construct($message);
    }
}
