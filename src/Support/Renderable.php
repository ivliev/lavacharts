<?php

namespace Hypoid\Lavacharts\Support;

use \Hypoid\Lavacharts\Values\Label;
use \Hypoid\Lavacharts\Values\ElementId;
use \Hypoid\Lavacharts\Support\Traits\ElementIdTrait as HasElementId;

/**
 * Renderable Class
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
class Renderable
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
     * Sets the renderable's ElementId or generates on from a string
     *
     * @param \Hypoid\Lavacharts\Values\Label     $label
     * @param \Hypoid\Lavacharts\Values\ElementId $elementId
     */
    public function __construct(Label $label, ?ElementId $elementId = null)
    {
        $this->label = $label;

        if ($elementId === null) {
            $this->generateElementId();
        } else {
            $this->elementId = $elementId;
        }
    }

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
     * Generate an ElementId
     *
     * This method removes invalid characters from the chart label
     * to use as an elementId.
     *
     * @link http://stackoverflow.com/a/11330527/2503458
     * @access private
     */
    private function generateElementId()
    {
        $string = strtolower((string) $this->label);
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        $string = preg_replace("/[\s-]+/", " ", $string);
        $string = preg_replace("/[\s_]/", "-", $string);

        $this->setElementId($string);
    }
}
