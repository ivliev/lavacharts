<?php

namespace Hypoid\Lavacharts\Exceptions;

class InvalidChartWrapperParams extends LavaException
{
    public function __construct()
    {
        $message  = "Invalid ChartWrapper parameters, must be (Chart, string)";

        parent::__construct($message);
    }
}
