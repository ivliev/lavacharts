<?php

namespace Hypoid\Lavacharts\Support\Traits;

use \Hypoid\Lavacharts\Values\Label;
use \Hypoid\Lavacharts\Values\ElementId;
use \Hypoid\Lavacharts\Support\Traits\ElementIdTrait as HasElementId;

/**
 * Trait RenderableTrait
 *
 * This class is the parent to charts, dashboards, and controls since they
 * will need to be rendered onto the page.
 *
 * @package    Hypoid\Lavacharts\Support
 * @since      3.1.0
 * @author     Kevin Hill <kevinkhill@gmail.com>
 * @copyright  (c) 2017, KHill Designs
 * @link       http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link       http://lavacharts.com                   Official Docs Site
 * @license    http://opensource.org/licenses/MIT MIT
 */
trait RenderableTrait
{
    use HasElementId;

    /**
     * The renderable's unique label.
     *
     * @var \Hypoid\Lavacharts\Values\Label
     */
    protected $label;

    /**
     * The renderable's unique elementId.
     *
     * @var \Hypoid\Lavacharts\Values\ElementId
     */
    protected $elementId;

    /**
     * Status for if a chart is directly renderable or if it is part of a dashboard.
     *
     * @var bool
     */
    protected $renderableStatus = true;

    /**
     * Creates and/or sets the Label.
     *
     * @param  string|\Hypoid\Lavacharts\Values\Label $label
     * @throws \Hypoid\Lavacharts\Exceptions\InvalidLabel
     */
    public function setLabel($label)
    {
        if ($label instanceof Label) {
            $this->label = $label;
        } else {
            $this->label = new Label($label);
        }
    }

    /**
     * Returns the label.
     *
     * @return \Hypoid\Lavacharts\Values\Label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Returns the label.
     *
     * @return \Hypoid\Lavacharts\Values\Label
     */
    public function getLabelStr()
    {
        return (string) $this->label;
    }

    /**
     * Sets the renderable status of the Chart
     *
     * @since  3.1.0
     * @param bool $renderable
     */
    public function setRenderable($renderable)
    {
        $this->renderableStatus = (bool) $renderable;
    }

    /**
     * Returns the status of the renderability of the chart.
     *
     * @since  3.1.0
     * @return bool
     */
    public function isRenderable()
    {
        return $this->renderableStatus;
    }
}
