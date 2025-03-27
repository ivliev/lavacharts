<?php

namespace Hypoid\Lavacharts\Tests\Values;

use Hypoid\Lavacharts\Tests\ProvidersTestCase;
use Hypoid\Lavacharts\Values\ElementId;

class ElementIdTest extends ProvidersTestCase
{
    public function testElementIdWithString()
    {
        $elementId = new ElementId('chart');

        $this->assertEquals('chart', (string) $elementId);
    }

    /**
     * @dataProvider nonStringProvider
     * @expectedException \Hypoid\Lavacharts\Exceptions\InvalidElementId
     */
    public function testElementIdWithBadTypes($badTypes)
    {
        $elementId = new ElementId($badTypes);
    }
}
