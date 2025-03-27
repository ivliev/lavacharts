<?php

namespace Hypoid\Lavacharts\Dashboards\Wrappers;

use Hypoid\Lavacharts\Values\ElementId;
use Hypoid\Lavacharts\Dashboards\Filters\Filter;

/**
 * ControlWrapper Class
 *
 * Used for building controls for dashboards.
 *
 * @package   Hypoid\Lavacharts\Dashboards\Wrappers
 * @since     3.0.0
 * @author    Kevin Hill <kevinkhill@gmail.com>
 * @copyright (c) 2017, KHill Designs
 * @link      http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link      http://lavacharts.com                   Official Docs Site
 * @license   http://opensource.org/licenses/MIT      MIT
 */
class ControlWrapper extends Wrapper
{
    /**
     * Type of wrapper.
     *
     * @var string
     */
    const TYPE = 'ControlWrapper';

    /**
     * Builds a ControlWrapper object.
     *
     * @param  \Hypoid\Lavacharts\Dashboards\Filters\Filter $filter
     * @param  \Hypoid\Lavacharts\Values\ElementId          $containerId
     */
    public function __construct(Filter $filter, ElementId $containerId)
    {
        parent::__construct($filter, $containerId);
    }
}
