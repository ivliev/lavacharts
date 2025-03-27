<?php

namespace Hypoid\Lavacharts\Dashboards\Filters;

use \Hypoid\Lavacharts\Exceptions\InvalidConfigValue;
use \Hypoid\Lavacharts\Exceptions\InvalidFilter;
use Hypoid\Lavacharts\Exceptions\InvalidFilterType;
use Hypoid\Lavacharts\Exceptions\InvalidParamType;

/**
 * FilterFactory creates new filters for use in a dashboard.
 *
 *
 * @package   Hypoid\Lavacharts\Dashboards\Filters
 * @since     3.1.0
 * @author    Kevin Hill <kevinkhill@gmail.com>
 * @copyright (c) 2017, KHill Designs
 * @link      http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link      http://lavacharts.com                   Official Docs Site
 * @license   http://opensource.org/licenses/MIT MIT
 */
class FilterFactory
{
    /**
     * Valid filter types
     *
     * @var array
     */
    public static $FILTER_TYPES = [
        'Category',
        'ChartRange',
        'DateRange',
        'NumberRange',
        'String'
    ];

    /**
     * Create a new Filter.
     *
     * @param  string     $type
     * @param  string|int $columnLabelOrIndex
     * @param  array      $config
     * @return \Hypoid\Lavacharts\Dashboards\Filters\Filter
     * @throws \Hypoid\Lavacharts\Exceptions\InvalidFilterType
     * @throws \Hypoid\Lavacharts\Exceptions\InvalidParamType
     */
    public static function create($type, $columnLabelOrIndex, array $config = [])
    {
        if (is_string($type)) {
            $type = str_replace('Filter', '', $type);
        }

        if (in_array($type, self::$FILTER_TYPES, true) === false) {
            throw new InvalidFilterType($type);
        }

        if (is_string($columnLabelOrIndex) === false && is_int($columnLabelOrIndex) === false) {
            throw new InvalidParamType($columnLabelOrIndex, 'string | int');
        }

        $filter = self::makeNamespace($type);

        return new $filter($columnLabelOrIndex, $config);
    }

    /**
     * Build the namespace to create a new filter.
     *
     * @param  string $filter
     * @return string
     */
    private static function makeNamespace($filter)
    {
        if (strpos($filter, 'range') !== false) {
            $filter = ucfirst(str_replace('range', 'Range', $filter));
        }

        return __NAMESPACE__ . '\\' . $filter . 'Filter';
    }
}
