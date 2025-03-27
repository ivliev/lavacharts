<?php

namespace Hypoid\Lavacharts\Builders;

use Hypoid\Lavacharts\Charts\ChartFactory;
use Hypoid\Lavacharts\DataTables\DataTable;
use Hypoid\Lavacharts\Exceptions\InvalidChartType;

/**
 * Class ChartBuilder
 *
 * This class is used to build charts by setting the properties, instead of trying to cover
 * everything in the constructor.
 *
 * @package    Hypoid\Lavacharts\Builders
 * @since      3.1.0
 * @author     Kevin Hill <kevinkhill@gmail.com>
 * @copyright  (c) 2017, KHill Designs
 * @link       http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link       http://lavacharts.com                   Official Docs Site
 * @license    http://opensource.org/licenses/MIT      MIT
 */
class ChartBuilder extends GenericBuilder
{
    /**
     * Type of chart to create.
     *
     * @var string
     */
    protected $type = null;

    /**
     * Datatable for the chart.
     *
     * @var \Hypoid\Lavacharts\DataTables\DataTable
     */
    protected $datatable = null;

    /**
     * Options for the chart.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The chart's png output override.
     *
     * @var bool
     */
    protected $pngOutput = false;

    /**
     * The chart's material output override.
     *
     * @var bool
     */
    protected $materialOutput = false;

    /**
     * Set the type of chart to create.
     *
     * @param  string $type Type of chart.
     * @return self
     * @throws \Hypoid\Lavacharts\Exceptions\InvalidChartType description
     */
    public function setType($type)
    {
        if (ChartFactory::isValidChart($type) === false) {
            throw new InvalidChartType($type);
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Sets the DataTable for the chart.
     *
     * @param  \Hypoid\Lavacharts\DataTables\DataTable $datatable
     * @return self
     */
    public function setDatatable(?DataTable $datatable = null)
    {
        $this->datatable = $datatable;

        return $this;
    }

    /**
     * Sets the options for the chart.
     *
     * @param  array $options
     * @return self
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Sets the charts output override.
     *
     * @param  bool $png
     * @return self
     */
    public function setPngOutput($png)
    {
        $this->pngOutput = (is_bool($png) ? $png : false);

        return $this;
    }

    /**
     * Sets the charts output override.
     *
     * @param  bool $material
     * @return self
     */
    public function setMaterialOutput($material)
    {
        $this->materialOutput = (is_bool($material) ? $material : false);

        return $this;
    }

    /**
     * Creates the chart from the assigned values.
     *
     * @return \Hypoid\Lavacharts\Charts\Chart
     */
    public function getChart()
    {
        $chart =  '\\Khill\\Lavacharts\\Charts\\' . $this->type;

        /** @var \Hypoid\Lavacharts\Charts\Chart $newChart */
        $newChart = new $chart(
            $this->label,
            $this->datatable,
            $this->options
        );

        if (array_key_exists('elementId', $this->options)) {
            $newChart->setElementId($this->options['elementId']);
        }

        if (isset($this->elementId)) {
            $newChart->setElementId($this->elementId);
        }

        if (method_exists($newChart, 'setPngOutput')) {
            $newChart->setPngOutput($this->pngOutput);
        }

        if (method_exists($newChart, 'setMaterialOutput')) {
            $newChart->setMaterialOutput($this->materialOutput);
        }

        return $newChart;
    }
}
