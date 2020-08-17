<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;

use \stdClass;

use Eightfold\Shoop\PipeFilters\Reverse;

/**
 * @group Reverse
 */
class ReverseTest extends TestCase
{
    /**
     * @test
     */
    public function list()
    {
        $using = [1, 2, 3];

        $expected = [3, 2, 1];

        $actual = Reverse::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 4.55);

        $this->start = hrtime(true);
        $using = ["a" => 1, "b" => 2, "c" => 3];

        $expected = ["c" => 3, "b" => 2, "a" => 1];

        $actual = Reverse::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }
    /**
     * @test
     */
    public function string()
    {
        $this->assertFalse(true);
    }
}
