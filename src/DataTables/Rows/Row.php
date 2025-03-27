<?php

namespace Hypoid\Lavacharts\DataTables\Rows;

use Carbon\Carbon;
use Hypoid\Lavacharts\DataTables\Cells\NullCell;
use Hypoid\Lavacharts\Values\StringValue;
use Hypoid\Lavacharts\DataTables\Cells\Cell;
use Hypoid\Lavacharts\DataTables\Cells\DateCell;
use Hypoid\Lavacharts\DataTables\DataTable;
use Hypoid\Lavacharts\Exceptions\InvalidCellCount;
use Hypoid\Lavacharts\Exceptions\InvalidColumnIndex;
use Hypoid\Lavacharts\Exceptions\InvalidDate;
use Hypoid\Lavacharts\Exceptions\InvalidRowDefinition;

/**
 * Row Object
 *
 * The row object contains all the data for a row, stored in an array, indexed by columns.
 *
 *
 * @package   Hypoid\Lavacharts\DataTables\Rows
 * @since     3.0.0
 * @author    Kevin Hill <kevinkhill@gmail.com>
 * @copyright (c) 2017, KHill Designs
 * @link      http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link      http://lavacharts.com                   Official Docs Site
 * @license   http://opensource.org/licenses/MIT      MIT
 */
class Row implements \ArrayAccess, \JsonSerializable
{
    /**
     * Row values
     *
     * @var \Hypoid\Lavacharts\DataTables\Cells\Cell[]
     */
    protected $values;

    /**
     * Creates a new Row object with the given values from an array.
     *
     * While iterating through the array, if the value is a...
     *  - Carbon instance, create a DateCell
     *  - null value, create a NullCell
     *  - primitive value, create a Cell
     *  - Cell, pass it through
     *
     * @param array $valueArray Array of row values.
     */
    public function __construct($valueArray)
    {
        $this->values = array_map(function ($cellValue) {
            if ($cellValue instanceof Carbon) {
                return new DateCell($cellValue);
            }

            if (is_null($cellValue)) {
                return new NullCell();
            }

            if ($cellValue instanceof Cell) {
                return $cellValue;
            }

            return new Cell($cellValue);
        }, $valueArray);
    }

    /**
     * Creates a new Row object from an array of values.
     *
     * @param \Hypoid\Lavacharts\DataTables\DataTable $datatable
     * @param  array                                 $valueArray Array of values to assign to the row.
     * @return \Hypoid\Lavacharts\DataTables\Rows\Row
     * @throws \Hypoid\Lavacharts\Exceptions\InvalidCellCount
     * @throws \Hypoid\Lavacharts\Exceptions\InvalidDate
     * @throws \Hypoid\Lavacharts\Exceptions\InvalidRowDefinition
     */
    public static function create(DataTable $datatable, $valueArray)
    {
        if ($valueArray !== null && is_array($valueArray) === false) {
            throw new InvalidRowDefinition($valueArray);
        }

        if ($valueArray === null || is_array($valueArray) && empty($valueArray)) {
            return new NullRow($datatable->getColumnCount());
        }

        $cellCount   = count($valueArray);
        $columnCount = $datatable->getColumnCount();

        if ($cellCount > $columnCount) {
            throw new InvalidCellCount($cellCount, $columnCount);
        }

        $columnTypes    = $datatable->getColumnTypes();
        $dateTimeFormat = $datatable->getDateTimeFormat();

        $rowData = [];

        foreach ($valueArray as $index => $cellValue) {
            if ((bool) preg_match('/date|datetime|timeofday/', $columnTypes[$index]) === true) {
                if (StringValue::isNonEmpty($cellValue) === false &&
                    $cellValue instanceof Carbon === false &&
                    $cellValue !== null
                ) {
                    throw new InvalidDate($cellValue);
                }

                if ($cellValue === null) {
                    $rowData[] = new NullCell;
                } else if ($cellValue instanceof Carbon) {
                    $rowData[] = new DateCell($cellValue);
                } else {
                    if (isset($dateTimeFormat)) {
                        $rowData[] = DateCell::parseString($cellValue, $dateTimeFormat);
                    } else {
                        $rowData[] = DateCell::parseString($cellValue);
                    }
                }
            } else {
                if (is_array($cellValue) === true) {
                    $cell = new \ReflectionClass(
                        'Khill\\Lavacharts\\DataTables\\Cells\\Cell'
                    );

                    $rowData[] = $cell->newInstanceArgs($cellValue);
                } else {
                    $rowData[] = $cellValue;
                }
            }
        }

        return new self($rowData);
    }

    /**
     * Returns a column value from the Row.
     *
     * @param  int $columnIndex Column value to fetch from the row.
     * @throws \Hypoid\Lavacharts\Exceptions\InvalidColumnIndex
     * @return \Hypoid\Lavacharts\DataTables\Cells\Cell
     */
    public function getCell($columnIndex)
    {
        if (is_int($columnIndex) === false || isset($this->values[$columnIndex]) === false) {
            throw new InvalidColumnIndex($columnIndex, count($this->values));
        }

        return $this->values[$columnIndex];
    }

    /**
     * Custom json serialization of the row.
     *
     * @return array
     */
    public function jsonSerialize() : mixed
    {
        return ['c' => $this->values];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value):void
    {
        if (is_null($offset)) {
            $this->values[] = $value;
        } else {
            $this->values[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset):bool
    {
        return isset($this->values[$offset]);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset):void
    {
        unset($this->values[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset):mixed
    {
        return isset($this->values[$offset]) ? $this->values[$offset] : null;
    }
}
