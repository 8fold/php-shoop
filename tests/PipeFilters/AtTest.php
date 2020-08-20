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
     */
    public function booleans()
    {
    }

    /**
     * @test
     */
    public function numbers()
    {
        $using = 5;

        $this->start = hrtime(true);
        $expected = 1;

        $actual = At::applyWith(1)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 3.5);

        $this->start = hrtime(true);
        $expected = [0, 2];

        $actual = At::applyWith(0, 2)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function strings()
    {
        $using = "Raise your glass!";

        $expected = "your";

        $actual = At::applyWith(6, 7, 8, 9)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 6);
    }

    /**
     * @test
     */
    public function lists()
    {
        $using = [3, 4, 5];

        $this->start = hrtime(true);
        $expected = 4;

        $actual = At::applyWith(1)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 3.1);

        $using = ["first" => "hello", "second" => false, "third" => 3];

        $this->start = hrtime(true);
        $expected = ["first" => "hello", "third" => 3];

        $actual = At::applyWith("first", "third")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = [3, 4, 5];

        $this->start = hrtime(true);
        $expected = [4, 5];

        $actual = At::applyWith(1, 2)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function tuples()
    {
        $using = (object) ["first" => 0, "second" => true];

        $this->start = hrtime(true);
        $expected = (object) ["i0" => 0, "i1" => true];

        $actual = At::applyWith(0, 1)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 3.25);

        $this->start = hrtime(true);
        $expected = true;

        $actual = At::applyWith("second")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function fromObjects()
    {
    }
}
