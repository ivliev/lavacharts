<?php

namespace Hypoid\Lavacharts\Tests\Dashboards;

use Hypoid\Lavacharts\Tests\ProvidersTestCase;
use Hypoid\Lavacharts\Dashboards\Wrappers\ControlWrapper;

class ControlWrapperTest extends ProvidersTestCase
{
    public $mockElementId;
    public $jsonOutput;

    public function setUp()
    {
        parent::setUp();

        $this->mockElementId = $this->getMockElementId('TestLabel');

        $this->jsonOutput = '{"options":{"Option1":5,"Option2":true},"containerId":"TestLabel","controlType":"NumberRangeFilter"}';
    }

    public function getMockFilter()
    {
        return \Mockery::mock('\Hypoid\Lavacharts\Dashboards\Filters\NumberRangeFilter')
            ->shouldReceive('getType')
            ->once()
            ->andReturn('NumberRangeFilter')
            ->shouldReceive('getWrapType')
            ->once()
            ->andReturn('controlType')
            ->shouldReceive('jsonSerialize')
            ->once()
            ->andReturn([
                'Option1' => 5,
                'Option2' => true
            ])
            ->getMock();
    }

    /**
     * @covers \Hypoid\Lavacharts\Dashboards\Wrappers\Wrapper::getJsClass
     */
    public function testGetJsClass()
    {
        $filter = \Mockery::mock('\Hypoid\Lavacharts\Dashboards\Filters\StringFilter');

        $controlWrapper = new ControlWrapper($filter, $this->mockElementId);

        $javascript = 'google.visualization.ControlWrapper';

        $this->assertEquals($javascript, $controlWrapper->getJsClass());
    }

    public function testJsonSerialize()
    {
        $filter = $this->getMockFilter();

        $controlWrapper = new ControlWrapper($filter, $this->mockElementId);

        $this->assertEquals($this->jsonOutput, json_encode($controlWrapper));
    }

    /**
     * @depends testJsonSerialize
     */
    public function testToJson()
    {
        $filter = $this->getMockFilter();

        $controlWrapper = new ControlWrapper($filter, $this->mockElementId);

        $this->assertEquals($this->jsonOutput, $controlWrapper->toJson());
    }

    /**
     * @depends testGetJsClass
     * @depends testToJson
     */
    public function testGetJsConstructor()
    {
        $filter = $this->getMockFilter();

        $controlWrapper = new ControlWrapper($filter, $this->mockElementId);

        $this->assertEquals(
            'new google.visualization.ControlWrapper('.$this->jsonOutput.')',
            $controlWrapper->getJsConstructor()
        );
    }
}
