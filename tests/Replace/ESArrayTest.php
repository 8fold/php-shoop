<?php

namespace Eightfold\Shoop\Tests\Replace;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\ESArray;

class ESArrayTest extends TestCase
{
    public function test_type_juggling()
    {
        $expected = false;
        $actual = ESArray::fold([])->bool()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.25);

        $this->start = hrtime(true);
        $expected = ["i0" => 1, "i1" => 2];
        $actual = ESArray::fold([1, 2])->dictionary()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 2);

        $this->start = hrtime(true);
        $expected = '{"i0":1,"i1":2}';
        $actual = ESArray::fold([1, 2])->json()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 2);

        $this->start = hrtime(true);
        $expected = "8fold";
        $actual = ESArray::fold(["8f", "ld"])->string("o")->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 2.1);
    }
}
