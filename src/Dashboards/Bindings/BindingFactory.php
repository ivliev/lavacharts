<?php

namespace Hypoid\Lavacharts\Dashboards\Bindings;

use \Hypoid\Lavacharts\Dashboards\Wrappers\ChartWrapper;
use \Hypoid\Lavacharts\Dashboards\Wrappers\ControlWrapper;
use \Hypoid\Lavacharts\Exceptions\InvalidBindings;

/**
 * BindingFactory Class
 *
 * Creates new bindings for dashboards.
 *
 * @package   Hypoid\Lavacharts\Dashboards\Bindings
 * @since     3.0.0
 * @author    Kevin Hill <kevinkhill@gmail.com>
 * @copyright (c) 2017, KHill Designs
 * @link      http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link      http://lavacharts.com                   Official Docs Site
 * @license   http://opensource.org/licenses/MIT      MIT
 */
class BindingFactory
{
    /**
     * Create a new Binding for the dashboard.
     *
     * @param  mixed $controlWraps One or array of many ControlWrappers
     * @param  mixed $chartWraps   One or array of many ChartWrappers
     * @throws \Hypoid\Lavacharts\Exceptions\InvalidBindings
     * @return \Hypoid\Lavacharts\Dashboards\Bindings\Binding
     */
    public function create($controlWraps, $chartWraps)
    {
        if ($controlWraps instanceof ControlWrapper && $chartWraps instanceof ChartWrapper) {
            return new OneToOne($controlWraps, $chartWraps);
        }

        if ($controlWraps instanceof ControlWrapper && is_array($chartWraps)) {
            return new OneToMany($controlWraps, $chartWraps);
        }

        if (is_array($controlWraps) && $chartWraps instanceof ChartWrapper) {
            return new ManyToOne($controlWraps, $chartWraps);
        }

        if (is_array($chartWraps) && is_array($controlWraps)) {
            return new ManyToMany($controlWraps, $chartWraps);
        }

        throw new InvalidBindings;
    }
}
