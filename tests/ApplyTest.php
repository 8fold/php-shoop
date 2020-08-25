<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Filter\Apply;

/**
 * @group Apply
 */
class ApplyTestSuite extends TestCase
{
    public function test_as_array()
    {
        $this->start = hrtime(true);
        $using = "8fold";
        $expected = ["8", "f", "o", "l", "d"];
        $actual = Shoop::pipe($using, Apply::asArray())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.4);

        $this->start = hrtime(true);
        $using = ["8", "f", "o", "l", "d"];
        $expected = "8!f!o!l!d";
        $actual = Shoop::pipe($using, Apply::asString("!"))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = "8fold";
        $expected = "8!f!o!l!d";
        $actual = Shoop::pipe($using,
            Apply::asArray(),
            Apply::asString("!")
        )->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}
