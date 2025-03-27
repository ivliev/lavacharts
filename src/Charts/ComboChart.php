<?php

namespace Hypoid\Lavacharts\Charts;

use \Hypoid\Lavacharts\Support\Traits\PngRenderableTrait as PngRenderable;

/**
 * ComboChart Class
 *
 * A chart that lets you render each series as a different marker type from the following list:
 * line, area, bars, candlesticks and stepped area.
 *
 * To assign a default marker type for series, specify the seriesType property.
 * Use the series property to specify properties of each series individually.
 *
 *
 * @package   Hypoid\Lavacharts\Charts
 * @since     2.0.0
 * @author    Kevin Hill <kevinkhill@gmail.com>
 * @copyright (c) 2017, KHill Designs
 * @link      http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link      http://lavacharts.com                   Official Docs Site
 * @license   http://opensource.org/licenses/MIT      MIT
 */
class ComboChart extends Chart
{
    use PngRenderable;

    /**
     * Javascript chart type.
     *
     * @var string
     */
    const TYPE = 'ComboChart';

    /**
     * Javascript chart version.
     *
     * @var string
     */
    const VERSION = '1';

    /**
     * Javascript chart package.
     *
     * @var string
     */
    const VISUALIZATION_PACKAGE = 'corechart';
}
