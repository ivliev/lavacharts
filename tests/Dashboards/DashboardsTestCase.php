<?php

namespace Hypoid\Lavacharts\Tests\Dashboards;

use Hypoid\Lavacharts\Tests\Charts\MockChart;
use Hypoid\Lavacharts\Tests\ProvidersTestCase;

/**
 * @property \Mockery\Mock                            mockChartWrap
 * @property \Mockery\Mock                            mockControlWrap
 * @property \Hypoid\Lavacharts\Tests\Charts\MockChart mockChart
 */
class DashboardsTestCase extends ProvidersTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->mockChart = new MockChart(
            \Mockery::mock('\Hypoid\Lavacharts\Values\Label', ['TestChart'])->makePartial(),
            $this->partialDataTable
        );

        $this->mockChartWrap = \Mockery::mock('\Hypoid\Lavacharts\Dashboards\Wrappers\ChartWrapper', [
            $this->mockChart,
            \Mockery::mock('\Hypoid\Lavacharts\Values\ElementId', ['chart-div'])->makePartial()
        ])->makePartial();

        $this->mockControlWrap = \Mockery::mock('\Hypoid\Lavacharts\Dashboards\Wrappers\ControlWrapper', [
            \Mockery::mock('\Hypoid\Lavacharts\Dashboards\Filters\NumberRangeFilter')->makePartial(),
            \Mockery::mock('\Hypoid\Lavacharts\Values\ElementId', ['control-div'])->makePartial()
        ])->makePartial();
    }
}
