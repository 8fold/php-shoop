<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;

use \stdClass;

use Eightfold\Shoop\PipeFilters\Minus;

/**
 * @group Minus
 */
class MinusTest extends TestCase
{
    /**
     * @test
     */
    public function from_number()
    {
        $using = 1;

        $this->start = hrtime(true);
        $expected = 0;

        $actual = Minus::applyWith(1)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 0.75);

        $using = -1.2;

        $this->start = hrtime(true);
        $expected = -2.7;

        $actual = Minus::applyWith(1.5)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = -5.5;

        $expected = 1;

        $actual = Minus::applyWith(-6.5)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }
    /**
     * @test
     *
     * @group current
     */
    public function from_lists()
    {
        $this->assertFalse(true);
    }

    /**
     * @test
     */
    public function from_string()
    {
        $using = "  Do you remember when, we used to sing?  ";

        $this->start = hrtime(true);
        $expected = "Do you remember when, we used to sing?";

        $actual = Minus::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 1.6);

        $this->start = hrtime(true);
        $expected = "Do you remember when, we used to sing?  ";

        $actual = Minus::applyWith(true, false)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 1.5);

        $expected = "  Do you remember when, we used to sing?";

        $actual = Minus::applyWith(false, true)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = "Doyourememberwhen,weusedtosing?";

        $actual = Minus::applyWith(false, false)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function from_boolean_allows_invalid_index()
    {
    }

    /**
     * @test
     */
    public function from_tuples()
    {
    }
}
