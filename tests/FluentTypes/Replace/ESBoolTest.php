<?php

namespace Eightfold\Shoop\Tests\Replace;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\FluentTypes\ESBoolean;

class ESBooleanTest extends TestCase
{
    public function test_type_juggling()
    {
        $expected = "true";
        $actual = ESBoolean::fold(true)->string()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 2);

        $this->start = hrtime(true);
        $expected = '{"true":true,"false":false}';
        $actual = ESBoolean::fold(true)->json()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 2.05);

        $expected = new stdClass;
        $expected->true = true;
        $expected->false = false;
        $actual = ESBoolean::fold(true)->object()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 2.75);

        $this->start = hrtime(true);
        $expected = "true";
        $actual = ESBoolean::fold(true)->string()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.25);
    }
}
