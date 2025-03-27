<?php

namespace Hypoid\Lavacharts\Support\Traits;

use \Hypoid\Lavacharts\DataTables\DataTable;

/**
 * Trait DataTableTrait
 *
 * Provides common methods for working with DataTables.
 *
 *
 * @package   Hypoid\Lavacharts\Support\Traits
 * @author    Kevin Hill <kevinkhill@gmail.com>
 * @copyright (c) 2017, KHill Designs
 * @link      http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link      http://lavacharts.com                   Official Docs Site
 * @license   http://opensource.org/licenses/MIT      MIT
 */
trait DataTableTrait
{
    /**
     * Datatable for the renderable.
     *
     * @var \Hypoid\Lavacharts\DataTables\DataTable
     */
    private $datatable;

    /**
     * Sets the DataTable
     *
     * @since  3.1.0
     * @param  \Hypoid\Lavacharts\DataTables\DataTable $datatable
     * @return \Hypoid\Lavacharts\DataTables\DataTable
     */
    public function setDataTable(DataTable $datatable)
    {
        $this->datatable = $datatable;

        return $this;
    }

    /**
     * Returns the DataTable
     *
     * @since  3.0.0
     * @return \Hypoid\Lavacharts\DataTables\DataTable
     */
    public function getDataTable()
    {
        return $this->datatable;
    }

    /**
     * Returns a JSON string representation of the datatable.
     *
     * @since  2.5.0
     * @return string
     */
    public function getDataTableJson()
    {
        return json_encode($this->datatable);
    }
}
