<?php

namespace Hypoid\Lavacharts\Tests\Dashboards;

use Hypoid\Lavacharts\Tests\ProvidersTestCase;
use Hypoid\Lavacharts\Dashboards\Wrappers\ChartWrapper;

class ChartWrapperTest extends ProvidersTestCase
{
    public $mockElementId;
    public $jsonOutput;

    public function setUp()
    {
        parent::setUp();

        $this->mockElementId = $this->getMockElementId('TestLabel');

        $this->jsonOutput = '{"options":{"Option1":5,"Option2":true},"containerId":"TestLabel","chartType":"LineChart"}';
    }

    public function getMockLineChart()
    {
        return \Mockery::mock('\Hypoid\Lavacharts\Charts\LineChart')
            ->shouldReceive('setRenderable')
            ->once()
            ->with(false)
            ->shouldReceive('getType')
            ->once()
            ->andReturn('LineChart')
            ->shouldReceive('getWrapType')
            ->once()
            ->andReturn('chartType')
            ->shouldReceive('jsonSerialize')
            ->once()
            ->andReturn([
                'Option1' => 5,
                'Option2' => true
            ])
            ->getMock();
    }

    /**
     * @covers \Hypoid\Lavacharts\Dashboards\Wrappers\Wrapper::getElementId
     */
    public function testGetElementId()
    {
        $areaChart = \Mockery::mock('\Hypoid\Lavacharts\Charts\AreaChart')->makePartial();

        $chartWrapper = new ChartWrapper($areaChart, $this->mockElementId);

        $this->assertInstanceOf('\Hypoid\Lavacharts\Values\ElementId', $chartWrapper->getElementId());
        $this->assertEquals('TestLabel', $chartWrapper->getElementIdStr());
    }

    /**
     * @covers \Hypoid\Lavacharts\Dashboards\Wrappers\Wrapper::unwrap
     */
    public function testUnwrap()
    {
        $areaChart = \Mockery::mock('\Hypoid\Lavacharts\Charts\AreaChart')->makePartial();

        $chartWrapper = new ChartWrapper($areaChart, $this->mockElementId);

        $this->assertInstanceOf('\Hypoid\Lavacharts\Charts\AreaChart', $chartWrapper->unwrap());
    }

    /**
     * @covers \Hypoid\Lavacharts\Dashboards\Wrappers\Wrapper::getJsClass
     */
    public function testGetJsClass()
    {
        $chart = \Mockery::mock('\Hypoid\Lavacharts\Charts\LineChart')
            ->shouldReceive('setRenderable')
            ->once()
            ->with(false)
            ->getMock();

        $chartWrapper = new ChartWrapper($chart, $this->mockElementId);

        $javascript = 'google.visualization.ChartWrapper';

        $this->assertEquals($javascript, $chartWrapper->getJsClass());
    }

    public function testJsonSerialize()
    {
        $chart = $this->getMockLineChart();

        $chartWrapper = new ChartWrapper($chart, $this->mockElementId);

        $this->assertEquals($this->jsonOutput, json_encode($chartWrapper));
    }

    /**
     * @depends testJsonSerialize
     */
    public function testToJson()
    {
        $chart = $this->getMockLineChart();

        $chartWrapper = new ChartWrapper($chart, $this->mockElementId);

        $this->assertEquals($this->jsonOutput, $chartWrapper->toJson());
    }

    /**
     * @depends testGetJsClass
     * @depends testToJson
     */
    public function testGetJsConstructor()
    {
        $chart = $this->getMockLineChart();

        $chartWrapper = new ChartWrapper($chart, $this->mockElementId);

        $this->assertEquals(
            'new google.visualization.ChartWrapper('.$this->jsonOutput.')',
            $chartWrapper->getJsConstructor()
        );
    }
}
