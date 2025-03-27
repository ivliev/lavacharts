<?php

namespace Hypoid\Lavacharts\Tests\DataTables\Cells;

use Hypoid\Lavacharts\Tests\ProvidersTestCase;
use Hypoid\Lavacharts\DataTables\Cells\DateCell;

class DateCellTest extends ProvidersTestCase
{
    /**
     * @covers \Hypoid\Lavacharts\DataTables\Cells\DateCell::__construct
     */
    public function testConstructorArgs()
    {
        $mockCarbon = \Mockery::mock('\Carbon\Carbon[parse]', ['2015-09-04 9:31:00']);

        $column = new DateCell($mockCarbon, 'start', ['color'=>'red']);

        $this->assertInstanceOf('Carbon\Carbon', $this->inspect($column, 'v'));
        $this->assertEquals('start', $this->inspect($column, 'f'));

        //@TODO fix this
        //$this->assertTrue(is_array($this->inspect($column, 'p')));
    }


    /**
     * @covers \Hypoid\Lavacharts\DataTables\Cells\DateCell::parseString
     * @covers \Hypoid\Lavacharts\DataTables\Cells\DateCell::__toString
     */
    public function testParseStringWithNoFormat()
    {
        $cell = DateCell::parseString('3/24/1988 8:01:05');
        $this->assertEquals('Date(1988,2,24,8,1,5)', (string) $cell);

        $cell = DateCell::parseString('March 24th, 1988 8:01:05');
        $this->assertEquals('Date(1988,2,24,8,1,5)', (string) $cell);
    }

    /**
     * @covers \Hypoid\Lavacharts\DataTables\Cells\DateCell::parseString
     * @covers \Hypoid\Lavacharts\DataTables\Cells\DateCell::__toString
     */
    public function testParseStringWithFormat()
    {

        $cell = DateCell::parseString('5:45pm on Saturday 24th March 2012', 'g:ia \o\n l jS F Y');

        $this->assertEquals('Date(2012,2,24,17,45,0)', (string) $cell);
    }

    /**
     * @expectedException \Exception
     * @covers \Hypoid\Lavacharts\DataTables\Cells\DateCell::parseString
     */
    public function testParseStringWithBadDateTimeString()
    {
        DateCell::parseString('132/06/199210');
    }

    /**
     * @dataProvider nonStringOrNullProvider
     * @expectedException \Hypoid\Lavacharts\Exceptions\InvalidDateTimeString
     * @covers \Hypoid\Lavacharts\DataTables\Cells\DateCell::parseString
     */
    public function testParseStringWithBadTypesForDateTime($badTypes)
    {
        DateCell::parseString($badTypes);
    }

    /**
     * @expectedException \Hypoid\Lavacharts\Exceptions\InvalidDateTimeFormat
     * @covers \Hypoid\Lavacharts\DataTables\Cells\DateCell::parseString
     */
    public function testParseStringWithBadFormatString()
    {
        DateCell::parseString('1/2/2003', 'sushi');
    }

    /**
     * @dataProvider nonStringProvider
     * @covers \Hypoid\Lavacharts\DataTables\Cells\DateCell::parseString
     */
    public function testParseStringWithBadTypesForFormat()
    {
        DateCell::parseString('1/2/2003', ['imnotaformat']);
    }

    /**
     * @depends testConstructorArgs
     * @covers \Hypoid\Lavacharts\DataTables\Cells\DateCell::jsonSerialize
     */
    public function testJsonSerialization()
    {
        $mockCarbon = \Mockery::mock('\Carbon\Carbon[parse]', ['2015-09-04 9:31:00']);

        $cell = new DateCell($mockCarbon);

        $this->assertEquals('{"v":"Date(2015,8,4,9,31,0)"}', json_encode($cell));
    }
}
