<?php

namespace Hypoid\Lavacharts\Tests\Values;

use Hypoid\Lavacharts\Tests\ProvidersTestCase;
use Hypoid\Lavacharts\Values\Label;

class LabelTest extends ProvidersTestCase
{
    public function testLabelWithString()
    {
        $label = new Label('TheChart');

        $this->assertEquals('TheChart', (string) $label);
    }

    /**
     * @dataProvider nonStringProvider
     * @expectedException \Hypoid\Lavacharts\Exceptions\InvalidLabel
     */
    public function testLabelWithBadTypes($badTypes)
    {
        $label = new Label($badTypes);
    }
}
