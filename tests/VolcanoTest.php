<?php

namespace Hypoid\Lavacharts\Tests;

use Hypoid\Lavacharts\Volcano;

/**
 * @property \Mockery\MockInterface    mockDashboard
 * @property \Mockery\MockInterface    mockLineChart
 * @property \Mockery\Mock             mockBadLabel
 * @property \Mockery\Mock             mockGoodLabel
 * @property \Hypoid\Lavacharts\Volcano volcano
 */
class VolcanoTest extends ProvidersTestCase
{
    /**
     * @var \Hypoid\Lavacharts\Volcano
     */
    public $Volcano;

    public function setUp()
    {
        parent::setUp();

        $this->volcano = new Volcano;

        $this->mockGoodLabel = \Mockery::mock('\Hypoid\Lavacharts\Values\Label', ['TestRenderable'])->makePartial();

        $this->mockBadLabel = \Mockery::mock('\Hypoid\Lavacharts\Values\Label', ['Pumpkins'])->makePartial();

        $this->mockLineChart = \Mockery::mock('\Hypoid\Lavacharts\Charts\LineChart', [
            $this->mockGoodLabel,
            $this->getMockDataTable()
        ])->shouldReceive('getLabel')
          ->andReturn('TestRenderable')
          ->shouldReceive('getType')
          ->zeroOrMoreTimes()
          ->andReturn('LineChart')
          ->getMock();

        $this->mockDashboard = \Mockery::mock('\Hypoid\Lavacharts\Dashboards\Dashboard', [
            $this->mockGoodLabel,
            $this->getMockDataTable()
        ])->shouldReceive('getLabel')->andReturn('TestRenderable')->getMock();
    }

    /**
     * @group chart
     */
    public function testStoreWithChart()
    {
        $this->volcano->store($this->mockLineChart);

        $volcanoCharts = $this->inspect($this->volcano, 'charts');

        $chart = $volcanoCharts['LineChart']['TestRenderable'];

        $this->assertInstanceOf(self::NS.'\Charts\Chart', $chart);
    }

    /**
     * @group dash
     */
    public function testStoreWithDashboard()
    {
        $chart = \Mockery::mock('\Hypoid\Lavacharts\Dashboards\Dashboard', [
            $this->mockGoodLabel,
            $this->getMockDataTable()
        ])->shouldReceive('getLabel')
          ->andReturn('TestRenderable')
          ->getMock();

        $this->assertEquals($this->volcano->store($chart), $chart);
    }

    /**
     * @group chart
     * @depends testStoreWithChart
     */
    public function testCheckChart()
    {
        $this->volcano->store($this->mockLineChart);

        $this->assertTrue($this->volcano->checkChart('LineChart', $this->mockGoodLabel));

        $this->assertFalse($this->volcano->checkChart('LaserChart', $this->mockGoodLabel));
        $this->assertFalse($this->volcano->checkChart('LineChart', $this->mockBadLabel));
    }

    /**
     * @group chart
     * @depends testStoreWithChart
     * @depends testCheckChart
     */
    public function testGetChart()
    {
        $this->volcano->store($this->mockLineChart);

        $this->assertInstanceOf('\Hypoid\Lavacharts\Charts\LineChart', $this->volcano->get('LineChart', $this->mockGoodLabel));
    }

    /**
     * @group chart
     * @depends testStoreWithChart
     * @depends testCheckChart
     * @depends testGetChart
     * @expectedException \Hypoid\Lavacharts\Exceptions\ChartNotFound
     */
    public function testGetChartWithBadChartType()
    {
        $this->volcano->store($this->mockLineChart);
        $this->volcano->get('LaserChart', $this->mockGoodLabel);
    }

    /**
     * @group chart
     * @depends testStoreWithChart
     * @depends testCheckChart
     * @depends testGetChart
     * @expectedException \Hypoid\Lavacharts\Exceptions\ChartNotFound
     */
    public function testGetChartWithNonExistentLabel()
    {
        $this->volcano->store($this->mockLineChart);
        $this->volcano->get('LineChart', $this->mockBadLabel);
    }



    /**
     * @group dashboard
     */
    public function testStoreDashboard()
    {
        $this->assertEquals($this->volcano->store($this->mockDashboard), $this->mockDashboard);
    }

    /**
     * @group dashboard
     * @depends testStoreDashboard
     */
    public function testCheckDashboard()
    {
        $this->volcano->store($this->mockDashboard);

        $this->assertTrue($this->volcano->checkDashboard($this->mockGoodLabel));
    }

    /**
     * @group dashboard
     * @depends testStoreWithDashboard
     * @depends testCheckDashboard
     */
    public function testGetDashboard()
    {
        $this->volcano->store($this->mockDashboard);

        $dash = $this->volcano->get('Dashboard', $this->mockGoodLabel);

        $this->assertInstanceOf('\Hypoid\Lavacharts\Dashboards\Dashboard', $dash);
    }

    /**
     * @group dashboard
     * @depends testStoreWithDashboard
     * @depends testCheckDashboard
     * @depends testGetDashboard
     * @expectedException \Hypoid\Lavacharts\Exceptions\DashboardNotFound
     */
    public function testGetDashboardWithBadLabel()
    {
        $this->volcano->store($this->mockDashboard);

        $this->volcano->get('Dashboard', $this->mockBadLabel);
    }

    /**
     * @group chart
     * @group dashboard
     * @depends testGetChart
     * @depends testGetDashboard
     */
    public function testGetAll()
    {
        $this->volcano->store($this->mockLineChart);
        $this->volcano->store($this->mockDashboard);

        foreach ($this->volcano->getAll() as $renderable) {
            $this->assertInstanceOf('\Hypoid\Lavacharts\Support\Contracts\RenderableInterface', $renderable);
        }
    }
}
