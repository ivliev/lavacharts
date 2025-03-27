<?php

namespace Hypoid\Lavacharts\Support\Contracts;

use \Hypoid\Lavacharts\Values\Label;
use \Hypoid\Lavacharts\Values\ElementId;

/**
 * Interface RenderableInterface
 *
 * Defining the methods a class must have to be Renderable.
 *
 * @package    Hypoid\Lavacharts\Support
 * @since      3.1.0
 * @author     Kevin Hill <kevinkhill@gmail.com>
 * @copyright  (c) 2017, KHill Designs
 * @link       http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link       http://lavacharts.com                   Official Docs Site
 * @license    http://opensource.org/licenses/MIT MIT
 */
interface RenderableInterface
{
    /**
     * Creates and/or sets the Label.
     *
     * @param  string|\Hypoid\Lavacharts\Values\Label $label
     * @throws \Hypoid\Lavacharts\Exceptions\InvalidLabel
     */
    public function setLabel($label);

    /**
     * Returns the label.
     *
     * @return \Hypoid\Lavacharts\Values\Label
     */
    public function getLabel();

    /**
     * Returns the label.
     *
     * @return \Hypoid\Lavacharts\Values\Label
     */
    public function getLabelStr();
}
