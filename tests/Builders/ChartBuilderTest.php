<?php

namespace Hypoid\Lavacharts\Tests\Builders;

use Hypoid\Lavacharts\Builders\ChartBuilder;
use Hypoid\Lavacharts\Charts\LineChart;
use Hypoid\Lavacharts\Tests\ProvidersTestCase;

/**
 * @property \Hypoid\Lavacharts\Builders\ChartBuilder builder
 */
class ChartBuilderTest extends ProvidersTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->builder = new ChartBuilder();
    }

    public function testWithLabelAndDataTable()
    {
        $this->builder->setType('LineChart');
        $this->builder->setLabel('taco');
        $this->builder->setDatatable($this->getMockDataTable());

        $chart = $this->builder->getChart();

        $this->assertInstanceOf('\Hypoid\Lavacharts\Charts\LineChart', $chart);
        $this->assertEquals('taco', $chart->getLabelStr());
        $this->assertInstanceOf('\Hypoid\Lavacharts\Datatables\Datatable', $chart->getDataTable());
    }

    /**
     * @depends testWithLabelAndDataTable
     */
    public function testWithLabelAndDataTableAndOptions()
    {
        $this->builder->setType('LineChart');
        $this->builder->setLabel('taco');
        $this->builder->setDatatable($this->getMockDataTable());
        $this->builder->setOptions(['tacos' => 'good']);

        $chart = $this->builder->getChart();
        $options = $chart->getOptions();

        $this->assertArrayHasKey('tacos', $options);
        $this->assertEquals('good', $options['tacos']);
    }

    /**
     * @depends testWithLabelAndDataTable
     * @depends testWithLabelAndDataTableAndOptions
     */
    public function testWithLabelAndDataTableAndOptionsAndElementId()
    {
        $this->builder->setType('LineChart');
        $this->builder->setLabel('taco');
        $this->builder->setDatatable($this->getMockDataTable());
        $this->builder->setOptions(['tacos' => 'good']);
        $this->builder->setElementId('platter');

        $chart = $this->builder->getChart();

        $elementId = $this->inspect($chart, 'elementId');

        $this->assertInstanceOf('\Hypoid\Lavacharts\Values\ElementId', $elementId);
        $this->assertEquals('platter', (string) $elementId);
    }
}
