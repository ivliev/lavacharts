<?php

namespace Hypoid\Lavacharts\Dashboards\Wrappers;

use Hypoid\Lavacharts\Charts\Chart;
use Hypoid\Lavacharts\Values\ElementId;

/**
 * Class ChartWrapper
 *
 * Used for wrapping charts to use in dashboards.
 *
 * @package   Hypoid\Lavacharts\Dashboards\Wrappers
 * @since     3.0.0
 * @author    Kevin Hill <kevinkhill@gmail.com>
 * @copyright (c) 2017, KHill Designs
 * @link      http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link      http://lavacharts.com                   Official Docs Site
 * @license   http://opensource.org/licenses/MIT      MIT
 */
class ChartWrapper extends Wrapper
{
    /**
     * Type of wrapper.
     *
     * @var string
     */
    const TYPE = 'ChartWrapper';

    /**
     * Builds a ChartWrapper object.
     *
     * @param  \Hypoid\Lavacharts\Charts\Chart     $chart
     * @param  \Hypoid\Lavacharts\Values\ElementId $containerId
     */
    public function __construct(Chart $chart, ElementId $containerId)
    {
        $chart->setRenderable(false);

        parent::__construct($chart, $containerId);
    }
}
