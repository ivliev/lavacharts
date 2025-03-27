<?php

namespace Hypoid\Lavacharts\Tests\DataTables\Columns;

use Hypoid\Lavacharts\Tests\ProvidersTestCase;
use Hypoid\Lavacharts\DataTables\Columns\ColumnFactory;

class ColumnFactoryTest extends ProvidersTestCase
{
    /**
     * @var \Hypoid\Lavacharts\DataTables\Columns\ColumnFactory
     */
    public $columnFactory;

    public function setUp()
    {
        parent::setUp();

        $this->columnFactory = new ColumnFactory;
    }

    /**
     * @dataProvider columnTypeProvider
     * @covers \Hypoid\Lavacharts\DataTables\Columns\ColumnFactory::create
     */
    public function testCreateColumnsWithType($columnType)
    {
        $column = $this->columnFactory->create($columnType);

        $this->assertInstanceOf('\Hypoid\Lavacharts\DataTables\Columns\Column', $column);
        $this->assertEquals($columnType, $this->inspect($column, 'type'));
    }

    /**
     * @expectedException \Hypoid\Lavacharts\Exceptions\InvalidColumnType
     * @covers \Hypoid\Lavacharts\DataTables\Columns\ColumnFactory::create
     */
    public function testCreateColumnsWithBadValue()
    {
        $this->columnFactory->create('milkshakes');
    }

    /**
     * @dataProvider nonStringProvider
     * @expectedException \Hypoid\Lavacharts\Exceptions\InvalidColumnType
     * @covers \Hypoid\Lavacharts\DataTables\Columns\ColumnFactory::create
     */
    public function testCreateColumnsWithBadTypes($badTypes)
    {
        $this->columnFactory->create($badTypes);
    }

    /**
     * @dataProvider columnTypeProvider
     * @depends testCreateColumnsWithType
     * @covers \Hypoid\Lavacharts\DataTables\Columns\ColumnFactory::create
     */
    public function testCreateColumnsWithTypeAndLabel($columnType)
    {
        $column = $this->columnFactory->create($columnType, 'Label');

        $this->assertInstanceOf('\Hypoid\Lavacharts\DataTables\Columns\Column', $column);
        $this->assertEquals($columnType, $this->inspect($column, 'type'));
        $this->assertEquals('Label', $this->inspect($column, 'label'));
    }

    /**
     * @dataProvider columnTypeProvider
     * @depends testCreateColumnsWithTypeAndLabel
     * @covers \Hypoid\Lavacharts\DataTables\Columns\ColumnFactory::create
     */
    public function testCreateColumnsWithTypeAndLabelAndFormat($columnType)
    {
        $mockFormat = \Mockery::mock('\Hypoid\Lavacharts\DataTables\Formats\NumberFormat')->makePartial();

        $column = $this->columnFactory->create($columnType, 'Label', $mockFormat);

        $this->assertInstanceOf('\Hypoid\Lavacharts\DataTables\Columns\Column', $column);
        $this->assertEquals($columnType, $this->inspect($column, 'type'));
        $this->assertEquals('Label', $this->inspect($column, 'label'));
        $this->assertInstanceOf('\Hypoid\Lavacharts\DataTables\Formats\NumberFormat', $this->inspect($column, 'format'));
    }

    /**
     * @dataProvider columnTypeProvider
     * @depends testCreateColumnsWithTypeAndLabelAndFormat
     * @covers \Hypoid\Lavacharts\DataTables\Columns\ColumnFactory::create
     */
    public function testCreateColumnsWithTypeAndLabelAndFormatAndRole($columnType)
    {
        $mockFormat = \Mockery::mock('\Hypoid\Lavacharts\DataTables\Formats\NumberFormat')->makePartial();

        $column = $this->columnFactory->create($columnType, 'Label', $mockFormat, 'interval');

        $this->assertInstanceOf('\Hypoid\Lavacharts\DataTables\Columns\Column', $column);
        $this->assertEquals($columnType, $this->inspect($column, 'type'));
        $this->assertEquals('Label', $this->inspect($column, 'label'));
        $this->assertInstanceOf('\Hypoid\Lavacharts\DataTables\Formats\NumberFormat', $this->inspect($column, 'format'));
        $this->assertInstanceOf('\Hypoid\Lavacharts\Values\Role', $this->inspect($column, 'role'));
        //@TODO remove me
        //$this->assertEquals('interval', $this->inspect($column, 'role'));
    }

    /**
     * @depends testCreateColumnsWithTypeAndLabelAndFormatAndRole
     * @covers \Hypoid\Lavacharts\DataTables\Columns\ColumnFactory::create
     * @expectedException \Hypoid\Lavacharts\Exceptions\InvalidColumnRole
     */
    public function testCreateColumnsWithTypeAndLabelAndFormatAndRoleWithBadRole()
    {
        $mockFormat = \Mockery::mock('\Hypoid\Lavacharts\DataTables\Formats\NumberFormat')->makePartial();

        $this->columnFactory->create('number', 'Label', $mockFormat, 'tacos');
    }
}
