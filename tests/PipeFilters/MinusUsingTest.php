<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;

use \stdClass;

use Eightfold\Shoop\PipeFilters\MinusUsing;

/**
 * @group Minus
 * @group MinusUsing
 */
class MinusUsingTest extends TestCase
{
    /**
     * @test
     */
    public function from_number()
    {
    }

    /**
     * @test
     */
    public function from_lists()
    {
        $using = [null, "8fold", false, "", "!"];

        $this->start = hrtime(true);
        $expected = ["8fold", "!"];

        $actual = MinusUsing::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 1);

        $this->start = hrtime(true);
        $expected = [false];

        $actual = MinusUsing::applyWith("is_bool")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = [null];

        $actual = MinusUsing::applyWith(function ($v) { return is_null($v); })
            ->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function from_string()
    {
    }

    /**
     * @test
     */
    public function from_boolean()
    {
    }

    /**
     * @test
     */
    public function from_tuples()
    {
    }
}
