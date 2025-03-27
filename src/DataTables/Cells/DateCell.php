<?php

namespace Hypoid\Lavacharts\DataTables\Cells;

use Carbon\Carbon;
use Hypoid\Lavacharts\Exceptions\CarbonParseError;
use Hypoid\Lavacharts\Exceptions\InvalidDateTimeFormat;
use Hypoid\Lavacharts\Exceptions\InvalidDateTimeString;
use Hypoid\Lavacharts\Exceptions\InvalidStringValue;
use Hypoid\Lavacharts\Values\StringValue;

/**
 * DateCell Class
 *
 * Wrapper object to implement JsonSerializable on the Carbon object.
 *
 * @package   Hypoid\Lavacharts\DataTables\Cells
 * @since     3.0.0
 * @author    Kevin Hill <kevinkhill@gmail.com>
 * @copyright (c) 2017, KHill Designs
 * @link      http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link      http://lavacharts.com                   Official Docs Site
 * @license   http://opensource.org/licenses/MIT      MIT
 */
class DateCell extends Cell
{
    /**
     * Creates a new DateCell object from a Carbon object.
     *
     * @param  \Carbon\Carbon $carbon
     * @param  string         $format
     * @param  array          $options
     */
    public function __construct(?Carbon $carbon = null, $format = '', array $options = [])
    {
        parent::__construct($carbon, $format, $options);
    }

    /**
     * Parses a datetime string with or without a datetime format.
     *
     * Uses Carbon to create the values for the DateCell.
     *
     *
     * @param  string $dateTimeString
     * @param  string $dateTimeFormat
     * @return \Hypoid\Lavacharts\DataTables\Cells\Cell
     * @throws \Hypoid\Lavacharts\Exceptions\InvalidDateTimeFormat
     * @throws \Hypoid\Lavacharts\Exceptions\InvalidDateTimeString
     */
    public static function parseString($dateTimeString, $dateTimeFormat = '')
    {
        if ($dateTimeString === null) {
            return new DateCell();
        }

        if (StringValue::isNonEmpty($dateTimeString) === false) {
            throw new InvalidDateTimeString($dateTimeString);
        }

        if (StringValue::isNonEmpty($dateTimeFormat)) {
            try {
                return self::createFromFormat($dateTimeFormat, $dateTimeString);
            } catch (\Exception $e) {
                throw new InvalidDateTimeFormat($dateTimeFormat);
            }
        } else {
            try {
                $carbon = Carbon::parse($dateTimeString);

                return new DateCell($carbon);
            } catch (\Exception $e) {
                throw new InvalidDateTimeString($dateTimeString);
            }
        }
    }

    /**
     * Create a new DateCell from a datetime string and a format.
     *
     * Carbon is used to validate the input.
     *
     * @param  string $format
     * @param  string $datetime
     * @return \Hypoid\Lavacharts\DataTables\Cells\DateCell
     * @throws \Hypoid\Lavacharts\Exceptions\InvalidDateTimeFormat
     */
    public static function createFromFormat($format, $datetime)
    {
        try {
            $carbon = Carbon::createFromFormat($format, $datetime);

            return new self($carbon);
        } catch (\InvalidArgumentException $e) {
            throw new InvalidDateTimeFormat($format);
        }
    }

    /**
     * Custom string output of the Carbon date.
     *
     * @return string
     */
    public function __toString()
    {
        if (!is_object($this->v)) {
            return 'null';
        }

        return sprintf(
            'Date(%d,%d,%d,%d,%d,%d)',
            isset($this->v->year)   ? $this->v->year      : 'null',
            isset($this->v->month)  ? $this->v->month - 1 : 'null', //silly javascript
            isset($this->v->day)    ? $this->v->day       : 'null',
            isset($this->v->hour)   ? $this->v->hour      : 'null',
            isset($this->v->minute) ? $this->v->minute    : 'null',
            isset($this->v->second) ? $this->v->second    : 'null'
        );
    }

    /**
     * Custom serialization of the Carbon date.
     *
     * @return string
     */
    public function jsonSerialize():mixed
    {
        return ['v' => (string) $this];
    }
}
