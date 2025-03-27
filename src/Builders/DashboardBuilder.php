<?php

namespace Hypoid\Lavacharts\Builders;

use \Hypoid\Lavacharts\Dashboards\Dashboard;
use \Hypoid\Lavacharts\DataTables\DataTable;

/**
 * Class DashboardBuilder
 *
 * This class is used to build dashboards by setting the properties, instead of trying to cover
 * everything in the constructor.
 *
 * @package    Hypoid\Lavacharts\Builders
 * @since      3.0.3
 * @author     Kevin Hill <kevinkhill@gmail.com>
 * @copyright  (c) 2017, KHill Designs
 * @link       http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link       http://lavacharts.com                   Official Docs Site
 * @license    http://opensource.org/licenses/MIT MIT
 */
class DashboardBuilder extends GenericBuilder
{
    /**
     * Datatable for the chart.
     *
     * @var \Hypoid\Lavacharts\DataTables\DataTable
     */
    protected $datatable = null;

    /**
     * Bindings to use for the dashboard.
     *
     * @var \Hypoid\Lavacharts\Dashboards\Bindings\Binding[]
     */
    protected $bindings = [];

    /**
     * Set the bindings for the Dashboard.
     *
     * @param  \Hypoid\Lavacharts\Dashboards\Bindings\Binding[] $bindings Array of bindings
     * @return $this
     */
    public function setBindings(array $bindings)
    {
        $this->bindings = $bindings;

        return $this;
    }

    /**
     * Set the DataTable for the dashboard
     *
     * @param \Hypoid\Lavacharts\DataTables\DataTable $datatable
     * @return $this
     */
    public function setDataTable(DataTable $datatable)
    {
        $this->datatable = $datatable;

        return $this;
    }

    /**
     * Returns the built Dashboard.
     *
     * @return \Hypoid\Lavacharts\Dashboards\Dashboard
     */
    public function getDashboard()
    {
        $dash = new Dashboard(
            $this->label,
            $this->datatable,
            $this->elementId
        );

        return $dash->setBindings($this->bindings);
    }
}
