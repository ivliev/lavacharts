<?php

namespace Hypoid\Lavacharts\Tests\Dashboards;

use Hypoid\Lavacharts\Dashboards\Bindings\BindingFactory;

/**
 * @property \Hypoid\Lavacharts\Dashboards\Bindings\BindingFactory factory
 */
class BindingFactoryTest extends DashboardsTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->factory = new BindingFactory;
    }

    /**
     * @covers \Hypoid\Lavacharts\Dashboards\Bindings\OneToOne
     * @covers \Hypoid\Lavacharts\Dashboards\Bindings\BindingFactory::create
     */
    public function testBindWithOneToOne()
    {
        $binding = $this->factory->create($this->mockControlWrap, $this->mockChartWrap);

        $this->assertInstanceOf('\Hypoid\Lavacharts\Dashboards\Bindings\OneToOne', $binding);
    }

    /**
     * @covers \Hypoid\Lavacharts\Dashboards\Bindings\OneToMany
     * @covers \Hypoid\Lavacharts\Dashboards\Bindings\BindingFactory::create
     */
    public function testBindWithOneToMany()
    {
        $binding = $this->factory->create(
            $this->mockControlWrap,
            [$this->mockChartWrap, $this->mockChartWrap]
        );

        $this->assertInstanceOf('\Hypoid\Lavacharts\Dashboards\Bindings\OneToMany', $binding);
    }

    /**
     * @covers \Hypoid\Lavacharts\Dashboards\Bindings\ManyToOne
     * @covers \Hypoid\Lavacharts\Dashboards\Bindings\BindingFactory::create
     */
    public function testBindWithManyToOne()
    {
        $binding = $this->factory->create(
            [$this->mockControlWrap, $this->mockControlWrap],
            $this->mockChartWrap
        );

        $this->assertInstanceOf('\Hypoid\Lavacharts\Dashboards\Bindings\ManyToOne', $binding);
    }

    /**
     * @covers \Hypoid\Lavacharts\Dashboards\Bindings\ManyToMany
     * @covers \Hypoid\Lavacharts\Dashboards\Bindings\BindingFactory::create
     */
    public function testBindWithManyToMany()
    {
        $binding = $this->factory->create(
            [$this->mockControlWrap, $this->mockControlWrap],
            [$this->mockChartWrap, $this->mockChartWrap]
        );

        $this->assertInstanceOf('\Hypoid\Lavacharts\Dashboards\Bindings\ManyToMany', $binding);
    }
}
