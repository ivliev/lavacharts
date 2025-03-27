<?php

namespace Hypoid\Lavacharts\Tests\Providers;

use BadMethodCallException;
use Hypoid\Lavacharts\Charts\AnnotationChart;
use Hypoid\Lavacharts\Charts\AreaChart;
use Hypoid\Lavacharts\Charts\BarChart;
use Hypoid\Lavacharts\Charts\BubbleChart;
use Hypoid\Lavacharts\Charts\CalendarChart;
use Hypoid\Lavacharts\Charts\CandlestickChart;
use Hypoid\Lavacharts\Charts\Chart;
use Hypoid\Lavacharts\Charts\ColumnChart;
use Hypoid\Lavacharts\Charts\ComboChart;
use Hypoid\Lavacharts\Charts\DonutChart;
use Hypoid\Lavacharts\Charts\GanttChart;
use Hypoid\Lavacharts\Charts\GaugeChart;
use Hypoid\Lavacharts\Charts\GeoChart;
use Hypoid\Lavacharts\Charts\HistogramChart;
use Hypoid\Lavacharts\Charts\LineChart;
use Hypoid\Lavacharts\Charts\OrgChart;
use Hypoid\Lavacharts\Charts\PieChart;
use Hypoid\Lavacharts\Charts\SankeyChart;
use Hypoid\Lavacharts\Charts\ScatterChart;
use Hypoid\Lavacharts\Charts\SteppedAreaChart;
use Hypoid\Lavacharts\Charts\TableChart;
use Hypoid\Lavacharts\Charts\TimelineChart;
use Hypoid\Lavacharts\Charts\TreeMapChart;
use Hypoid\Lavacharts\Charts\WordTreeChart;
use Hypoid\Lavacharts\DataTables\DataTable;

class ChartProvider
{
    /**
     * Return a test Chart by type.
     *
     * @param string    $type
     * @param DataTable $data
     * @return Chart
     */
    public static function make($type, DataTable $data)
    {
        if (method_exists(static::class, $type)) {
            return static::$type($data);
        } else {
            throw new BadMethodCallException('There is no test chart for "'.$type.'"');
        }
    }

    /**
     * @param DataTable $data
     * @return AnnotationChart
     */
    public static function AnnotationChart(DataTable $data)
    {
        return new AnnotationChart('MyAnnotationChart', $data, [
            'elementId' => 'MyAnnotationChart',
            'displayAnnotations' => true
        ]);
    }

    /**
     * @param DataTable $data
     * @return AreaChart
     */
    public static function AreaChart(DataTable $data)
    {
        return new AreaChart('MyAreaChart', $data, [
            'elementId' => 'MyAreaChart',
            'legend' => [
                'position' => 'inner'
            ],
            'chartArea'=> [
                'left' => 50,
                'width' => '90%'
            ],
        ]);
    }

    /**
     * @param DataTable $data
     * @return BarChart
     */
    public static function BarChart(DataTable $data)
    {
        return new BarChart('MyBarChart', $data, [
            'elementId' => 'MyBarChart',
            'legend' => [
                'position' => 'top'
            ]
        ]);
    }

    /**
     * @param DataTable $data
     * @return BubbleChart
     */
    public static function BubbleChart(DataTable $data)
    {
        return new BubbleChart('MyBubbleChart', $data, [
            'elementId' => 'MyBubbleChart',
            'width' => 400,
            'height' => 400,
            'chartArea' => [
                'width' => 400
            ],
            'title' => 'Correlation between life expectancy, fertility rate ' .
                'and population of some world countries (2010)',
            'hAxis' => [
                'title' => 'Life Expectancy'
            ],
            'vAxis' => [
                'title' => 'Fertility Rate'
            ],
            'bubble' => [
                'textStyle' => [
                    'fontSize' => 11
                ]
            ]
        ]);
    }

    /**
     * @param DataTable $data
     * @return CalendarChart
     */
    public static function CalendarChart(DataTable $data)
    {
        return new CalendarChart('MyCalendarChart', $data, [
            'elementId' => 'MyCalendarChart',
            'title' => 'Cars Sold',
            'unusedMonthOutlineColor' => [
                'stroke'        => '#ECECEC',
                'strokeOpacity' => 0.75,
                'strokeWidth'   => 1
            ],
            'dayOfWeekLabel' => [
                'color' => '#4f5b0d',
                'fontSize' => 16,
                'italic' => true
            ],
            'noDataPattern' => [
                'color' => '#DDD',
                'backgroundColor' => '#11FFFF'
            ],
            'colorAxis' => [
                'values' => [0, 100],
                'colors' => ['black', 'green']
            ]
        ]);
    }

    /**
     * @param DataTable $data
     * @return CandlestickChart
     */
    public static function CandlestickChart(DataTable $data)
    {
        return new CandlestickChart('MyCandlestickChart', $data, [
            'elementId' => 'MyCandlestickChart',
            'legend' => 'none',
            'height' => 400
        ]);
    }

    /**
     * @param DataTable $data
     * @return ColumnChart
     */
    public static function ColumnChart(DataTable $data)
    {
        return new ColumnChart('MyColumnChart', $data, [
            'elementId' => 'MyColumnChart',
            'title' => 'Company Performance',
            'titleTextStyle' => [
                'color' => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);
    }

    /**
     * @param DataTable $data
     * @return ComboChart
     */
    public static function ComboChart(DataTable $data)
    {
        return new ComboChart('MyComboChart', $data, [
            'elementId' => 'MyComboChart',
            'title' => 'Company Performance',
            'titleTextStyle' => [
                'color' => 'rgb(123, 65, 89)',
                'fontSize' => 16,
                'bold' => true
            ],
            'legend' => [
                'position' => 'in'
            ],
            'seriesType' => 'bars',
            'series' => [
                2 => [
                    'type' => 'line'
                ]
            ]
        ]);
    }

    /**
     * @param DataTable $data
     * @return DonutChart
     */
    public static function DonutChart(DataTable $data)
    {
        return new DonutChart('MyDonutChart', $data, [
            'elementId' => 'MyDonutChart'
        ]);
    }

    /**
     * @param DataTable $data
     * @return GanttChart
     */
    public static function GanttChart(DataTable $data)
    {
        return new GanttChart('MyGanttChart', $data, [
            'elementId' => 'MyGanttChart',
            'height' => 275
        ]);
    }

    /**
     * @param DataTable $data
     * @return GaugeChart
     */
    public static function GaugeChart(DataTable $data)
    {
        return new GaugeChart('MyGaugeChart', $data, [
            'elementId' => 'MyGaugeChart',
            'greenFrom' => 0,
            'greenTo' => 69,
            'yellowFrom' => 70,
            'yellowTo' => 89,
            'redFrom' => 90,
            'redTo' => 100,
            'majorTicks' => [
                'Safe',
                'Critical'
            ]
        ]);
    }

    /**
     * @param DataTable $data
     * @return GeoChart
     */
    public static function GeoChart(DataTable $data)
    {
        return new GeoChart('MyGeoChart', $data, [
            'elementId' => 'MyGeoChart',
            'width' => 500,
            'height' => 300,
        ]);
    }

    /**
     * @param DataTable $data
     * @return HistogramChart
     */
    public static function HistogramChart(DataTable $data)
    {
        return new HistogramChart('MyHistogramChart', $data, [
            'elementId' => 'MyHistogramChart',
            'title' => 'Lengths of dinosaurs, in meters',
            'legend' => 'none'
        ]);
    }

    /**
     * @param DataTable $data
     * @return LineChart
     */
    public static function LineChart(DataTable $data)
    {
        return new LineChart('MyLineChart', $data, [
            'elementId' => 'MyLineChart',
            'title' => 'Weather in October',
            'width' => '100%',
            'chartArea'=> [
                'left' => 50,
                'width' => '70%'
            ],
            'backgroundColor' => [
                'strokeWidth' => 6,
                'fill'        => '#A9D0F5',
                'stroke'      => '#007D7D',
            ]
        ]);
    }

    /**
     * @param DataTable $data
     * @return OrgChart
     */
    public static function OrgChart(DataTable $data)
    {
        return new OrgChart('MyOrgChart', $data, [
            'elementId' => 'MyOrgChart',
            'title' => 'Company Performance',
            'allowHtml' => true,
            'titleTextStyle' => [
                'color' => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);
    }

    /**
     * @param DataTable $data
     * @return PieChart
     */
    public static function PieChart(DataTable $data)
    {
        return new PieChart('MyPieChart', $data, [
            'elementId' => 'MyPieChart',
            'title' => 'Reasons I visit IMDB',
            'is3D' => true,
            'slices' => [
                ['offset' => 0.2],
                ['offset' => 0.25],
                ['offset' => 0.3]
            ]
        ]);
    }

    /**
     * @param DataTable $data
     * @return SankeyChart
     */
    public static function SankeyChart(DataTable $data)
    {
        $colors = [
            '#a6cee3',
            '#b2df8a',
            '#fb9a99',
            '#fdbf6f',
            '#cab2d6',
            '#ffff99',
            '#1f78b4',
            '#33a02c'
        ];

        return new SankeyChart('MySankeyChart', $data, [
            'elementId' => 'MySankeyChart',
            'legend' => [
                'position' => 'none'
            ],
            'sankey' => [
                'node' => [
                    'colors' => $colors
                ],
                'link' => [
                    'colorMode' => 'gradient',
                    'colors' => $colors
                ]
            ]
        ]);
    }

    /**
     * @param DataTable $data
     * @return ScatterChart
     */
    public static function ScatterChart(DataTable $data)
    {
        return new ScatterChart('MyScatterChart', $data, [
            'elementId' => 'MyScatterChart',
            'title' => 'Age vs. Weight comparison',
            'hAxis' => [
                'title' => 'Age',
                'minValue' => 20,
                'maxValue' => 40
            ],
            'vAxis' => [
                'title' => 'Age',
                'minValue' => 100,
                'maxValue' => 300
            ],
            'legend' => [
                'position' => 'none'
            ]
        ]);
    }

    /**
     * @param DataTable $data
     * @return SteppedAreaChart
     */
    public static function SteppedAreaChart(DataTable $data)
    {
        return new SteppedAreaChart('MySteppedAreaChart', $data, [
            'title' => 'The decline of \'The 39 Steps\'',
            'vAxis' => [
                'title' => 'Accumulated Rating'
            ],
            'isStacked' => true,
            'legend' => 'none'
        ]);
    }

    /**
     * @param DataTable $data
     * @return TableChart
     */
    public static function TableChart(DataTable $data)
    {
        return new TableChart('MyTableChart', $data);
    }

    /**
     * @param DataTable $data
     * @return TimelineChart
     */
    public static function TimelineChart(DataTable $data)
    {
        return new TimelineChart('MyTimelineChart', $data, [
            'elementId' => 'MyTimelineChart',
            'title' => 'Classes',
            'timeline' => [
                'colorByRowLabel' => true
            ]
        ]);
    }

    /**
     * @param DataTable $data
     * @return TreeMapChart
     */
    public static function TreeMapChart(DataTable $data)
    {
        return new TreeMapChart('MyTreeMapChart', $data, [
            'elementId' => 'MyTreeMapChart',
            'width' => 400,
            'height' => 200
        ]);
    }

    /**
     * @param DataTable $data
     * @return WordTreeChart
     */
    public static function WordTreeChart(DataTable $data)
    {
        return new WordTreeChart('MyWordTreeChart', $data, [
            'elementId' => 'MyWordTreeChart',
            'wordtree' => [
                'format' => 'implicit',
                'word' => 'cats'
            ]
        ]);
    }
}
