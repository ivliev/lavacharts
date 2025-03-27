<?php

namespace Hypoid\Lavacharts\DataTables\Columns;

use Hypoid\Lavacharts\DataTables\Formats\Format;
use Hypoid\Lavacharts\Exceptions\InvalidColumnRole;
use Hypoid\Lavacharts\Exceptions\InvalidColumnType;
use Hypoid\Lavacharts\Support\Customizable;
use Hypoid\Lavacharts\Values\Role;
use Hypoid\Lavacharts\Values\StringValue;

/**
 * Column Object
 *
 * The Column object is used to define the different columns for a DataTable.
 *
 *
 * @package   Hypoid\Lavacharts\DataTables\Columns
 * @since     3.1.0
 * @author    Kevin Hill <kevinkhill@gmail.com>
 * @copyright (c) 2017, KHill Designs
 * @link      http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link      http://lavacharts.com                   Official Docs Site
 * @license   http://opensource.org/licenses/MIT      MIT
 */
class ColumnBuilder
{
    /**
     * Column type.
     *
     * @var string
     */
    private $type;

    /**
     * Column label.
     *
     * @var string
     */
    private $label = '';

    /**
     * Column formatter.
     *
     * @var \Hypoid\Lavacharts\DataTables\Formats\Format
     */
    private $format = null;

    /**
     * Column role.
     *
     * @var \Hypoid\Lavacharts\Values\Role
     */
    private $role = null;

    /**
     * Column options
     *
     * @var array
     */
    private $options = [];

    /**
     * Sets the type of column.
     *
     * @param  string $type
     * @throws \Hypoid\Lavacharts\Exceptions\InvalidColumnType
     */
    public function setType($type)
    {
        if (StringValue::isNonEmpty($type) === false) {
            throw new InvalidColumnType($type, 'string');//--------------------
        }

        $this->type = $type;
    }

    /**
     * Sets the column label.
     *
     * @param  string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Sets the column formatter.
     *
     * @param \Hypoid\Lavacharts\DataTables\Formats\Format $format
     */
    public function setFormat(?Format $format = null)
    {
        $this->format = $format;
    }

    /**
     * Sets the column role.
     *
     * @param  string $role
     * @throws \Hypoid\Lavacharts\Exceptions\InvalidColumnRole
     */
    public function setRole($role)
    {
        if (StringValue::isNonEmpty($role)) {
            $this->role = new Role($role);
        }
    }

    /**
     * Sets the column options.
     *
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * Creates a new column instance with the set values.
     *
     * @return \Hypoid\Lavacharts\DataTables\Columns\Column
     */
    public function getResult()
    {
        return new Column(
            $this->type,
            $this->label,
            $this->format,
            $this->role,
            $this->options
        );
    }
}
