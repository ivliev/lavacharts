<?php

require('vendor/autoload.php');

use \Hypoid\Lavacharts\Charts\ChartFactory;

echo json_encode(ChartFactory::$CHART_TYPES);
