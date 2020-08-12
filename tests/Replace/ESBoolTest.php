<?php

namespace Eightfold\Shoop\Tests\Replace;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\ESBool;

class ESBoolTest extends TestCase
{
    public function test_type_juggling()
    {
        $expected = "true";
        $actual = ESBool::fold(true)->string()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.75);

        $this->start = hrtime(true);
        $expected = '{"true":true,"false":false}';
        $actual = ESBool::fold(true)->json()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 2.05);

        $expected = new stdClass;
        $expected->true = true;
        $expected->false = false;
        $actual = ESBool::fold(true)->object()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 2.75);

        $this->start = hrtime(true);
        $expected = "true";
        $actual = ESBool::fold(true)->string()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.25);
    }
}
