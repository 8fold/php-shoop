<?php

namespace Eightfold\Shoop\Tests\Replace;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\PipeFilters;

use Eightfold\Shoop\FluentTypes\ESInteger;

class ESIntegerTest extends TestCase
{
    public function test_type_juggling()
    {
        $expected = [0, 1, 2, 3, 4, 5];
        $actual = ESInteger::fold(5)->array()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 4);

        $expected = true;
        $actual = ESInteger::fold(1)->bool()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 4);

        $expected = true;
        $actual = ESInteger::fold(-1)->bool()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 4);

        $expected = false;
        $actual = ESInteger::fold(0)->bool()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 4);

        $this->start = hrtime(true);
        $expected = [
            "i0" => 0,
            "i1" => 1,
            "i2" => 2,
            "i3" => 3,
            "i4" => 4
        ];
        $actual = ESInteger::fold(4)->dictionary()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 2);

        $this->start = hrtime(true);
        $expected = '{"i0":0,"i1":1}';
        $actual = ESInteger::fold(1)->json()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = "10";
        $actual = ESInteger::fold(10)->string()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1);
    }
}
