<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;

use \stdClass;

use Eightfold\Shoop\PipeFilters\At;

/**
 * @group At
 */
class AtTest extends TestCase
{
    /**
     * @test
     *
     * @group current
     */
    public function from_lists()
    {
        $using = [3, 4, 5];

        $expected = 4;

        $actual = At::applyWith(1)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = ["first" => "hello", "second" => false, "third" => 3];

        $expected = ["first" => "hello", "third" => 3];

        $actual = At::applyWith("first", "third")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function from_number()
    {
        $using = 5;

        $this->start = hrtime(true);
        $expected = 1;

        $actual = At::applyWith(1)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 7.25);

        $this->start = hrtime(true);
        $expected = 2;

        $actual = At::applyWith(0, 2)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 1.3);

        $this->start = hrtime(true);
        $expected = 4;

        $actual = At::applyWith("i2", 2)->unfoldUsing($using);
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
