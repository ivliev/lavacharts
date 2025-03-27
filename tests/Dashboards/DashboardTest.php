<?php

namespace Hypoid\Lavacharts\Tests\Dashboards;

use Hypoid\Lavacharts\Dashboards\Dashboard;

/**
 * @property \Hypoid\Lavacharts\Dashboards\Dashboard   dashboard
 */
class DashboardTest extends DashboardsTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->dashboard = new Dashboard(
            \Mockery::mock('\Hypoid\Lavacharts\Values\Label', ['myDash'])->makePartial(),
            $this->partialDataTable,
            \Mockery::mock('\Hypoid\Lavacharts\Values\ElementId', ['my-dash'])->makePartial()
        );
    }

    /**
     * @covers \Hypoid\Lavacharts\Dashboards\Bindings\BindingFactory::create
     * @expectedException \Hypoid\Lavacharts\Exceptions\InvalidBindings
     */
    public function testBindingFactoryWithBadTypes()
    {
        $this->dashboard->bind(612345, 'tacos');
        $this->dashboard->bind(61.345, []);
        $this->dashboard->bind([], false);
    }
    /**
     * @covers \Hypoid\Lavacharts\Dashboards\Dashboard::bind
     * @covers \Hypoid\Lavacharts\Dashboards\Dashboard::getBindings
     */
    public function testGetBindings()
    {
        $this->dashboard->bind($this->mockControlWrap, $this->mockChartWrap);

        $bindings = $this->dashboard->getBindings();

        $this->assertTrue(is_array($bindings));
    }

    /**
     * @depends testGetBindings
     * @covers \Hypoid\Lavacharts\Dashboards\Dashboard::bind
     * @covers \Hypoid\Lavacharts\Dashboards\Dashboard::getBindings
     * @covers \Hypoid\Lavacharts\Dashboards\Bindings\OneToOne
     * @covers \Hypoid\Lavacharts\Dashboards\Bindings\BindingFactory::create
     */
    public function testBindWithOneToOne()
    {
        $this->dashboard->bind($this->mockControlWrap, $this->mockChartWrap);

        /** @var \Hypoid\Lavacharts\Dashboards\Bindings\Binding $binding */
        $binding = $this->dashboard->getBindings()[0];

        $this->assertInstanceOf('\Hypoid\Lavacharts\Dashboards\Bindings\OneToOne', $binding);
    }

    /**
     * @depends testGetBindings
     * @covers \Hypoid\Lavacharts\Dashboards\Dashboard::bind
     * @covers \Hypoid\Lavacharts\Dashboards\Dashboard::getBindings
     * @covers \Hypoid\Lavacharts\Dashboards\Bindings\OneToMany
     * @covers \Hypoid\Lavacharts\Dashboards\Bindings\BindingFactory::create
     */
    public function testBindWithOneToMany()
    {
        $this->dashboard->bind(
            $this->mockControlWrap,
            [$this->mockChartWrap, $this->mockChartWrap]
        );

        /** @var \Hypoid\Lavacharts\Dashboards\Bindings\Binding $binding */
        $binding = $this->dashboard->getBindings()[0];

        $this->assertInstanceOf('\Hypoid\Lavacharts\Dashboards\Bindings\OneToMany', $binding);
    }

    /**
     * @depends testGetBindings
     * @covers \Hypoid\Lavacharts\Dashboards\Dashboard::bind
     * @covers \Hypoid\Lavacharts\Dashboards\Dashboard::getBindings
     * @covers \Hypoid\Lavacharts\Dashboards\Bindings\ManyToOne
     * @covers \Hypoid\Lavacharts\Dashboards\Bindings\BindingFactory::create
     */
    public function testBindWithManyToOne()
    {
        $this->dashboard->bind(
            [$this->mockControlWrap, $this->mockControlWrap],
            $this->mockChartWrap
        );

        /** @var \Hypoid\Lavacharts\Dashboards\Bindings\Binding $binding */
        $binding = $this->dashboard->getBindings()[0];

        $this->assertInstanceOf('\Hypoid\Lavacharts\Dashboards\Bindings\ManyToOne', $binding);
    }

    /**
     * @depends testGetBindings
     * @covers \Hypoid\Lavacharts\Dashboards\Dashboard::bind
     * @covers \Hypoid\Lavacharts\Dashboards\Dashboard::getBindings
     * @covers \Hypoid\Lavacharts\Dashboards\Bindings\ManyToMany
     * @covers \Hypoid\Lavacharts\Dashboards\Bindings\BindingFactory::create
     */
    public function testBindWithManyToMany()
    {
        $this->dashboard->bind(
            [$this->mockControlWrap, $this->mockControlWrap],
            [$this->mockChartWrap, $this->mockChartWrap]
        );

        /** @var \Hypoid\Lavacharts\Dashboards\Bindings\Binding $binding */
        $binding = $this->dashboard->getBindings()[0];

        $this->assertInstanceOf('\Hypoid\Lavacharts\Dashboards\Bindings\ManyToMany', $binding);
    }

    /**
     * @depends testGetBindings
     * @covers \Hypoid\Lavacharts\Dashboards\Dashboard::bind
     * @covers \Hypoid\Lavacharts\Dashboards\Bindings\Binding
     */
    public function testGettingComponentsFromBinding()
    {
        $this->dashboard->bind($this->mockControlWrap, $this->mockChartWrap);

        /** @var \Hypoid\Lavacharts\Dashboards\Bindings\Binding $binding */
        $binding = $this->dashboard->getBindings()[0];

        $this->assertInstanceOf('\Hypoid\Lavacharts\Dashboards\Bindings\OneToOne', $binding);
        $this->assertInstanceOf('\Hypoid\Lavacharts\Dashboards\Wrappers\ControlWrapper',$binding->getControlWrappers()[0]);
        $this->assertInstanceOf('\Hypoid\Lavacharts\Dashboards\Wrappers\ChartWrapper', $binding->getChartWrappers()[0]);
    }
    /**
     * @depends testGetBindings
     * @depends testBindWithOneToMany
     * @covers \Hypoid\Lavacharts\Dashboards\Dashboard::getBoundCharts
     */
    public function testGetBoundChartsWithOneToMany()
    {
        $mockLineChartWrapper = \Mockery::mock('\Hypoid\Lavacharts\Dashboards\Wrappers\ChartWrapper', [
            \Mockery::mock('\Hypoid\Lavacharts\Charts\LineChart')->makePartial(),
            \Mockery::mock('\Hypoid\Lavacharts\Values\ElementId', ['line-chart'])->makePartial()
        ])->makePartial();
        //->shouldReceive('unwrap')
        //->once()->getMock();
        //->andReturn();

        $mockAreaChartWrapper = \Mockery::mock('\Hypoid\Lavacharts\Dashboards\Wrappers\ChartWrapper', [
            \Mockery::mock('\Hypoid\Lavacharts\Charts\AreaChart')->makePartial(),
            \Mockery::mock('\Hypoid\Lavacharts\Values\ElementId', ['area-chart'])->makePartial()
        ])->makePartial();
        //->shouldReceive('unwrap')
        //->once()->getMock();
        //->andReturn();

        $this->dashboard->bind(
            $this->mockControlWrap,
            [$mockLineChartWrapper, $mockAreaChartWrapper]
        );

        $charts = $this->dashboard->getBoundCharts();

        $this->assertTrue(is_array($charts));
        $this->assertInstanceOf('\Hypoid\Lavacharts\Charts\LineChart', $charts[0]);
        $this->assertInstanceOf('\Hypoid\Lavacharts\Charts\AreaChart', $charts[1]);
    }

    /**
     * @depends testGetBindings
     * @depends testBindWithOneToOne
     * @covers \Hypoid\Lavacharts\Dashboards\Dashboard::setBindings
     */
    public function testSetBindingsWithMultipleOneToOne()
    {
        $this->dashboard->setBindings([
            [$this->mockControlWrap, $this->mockChartWrap],
            [$this->mockControlWrap, $this->mockChartWrap]
        ]);

        $bindings = $this->dashboard->getBindings();

        $this->assertInstanceOf('\Hypoid\Lavacharts\Dashboards\Bindings\OneToOne', $bindings[0]);
        $this->assertInstanceOf('\Hypoid\Lavacharts\Dashboards\Bindings\OneToOne', $bindings[1]);
    }
}
