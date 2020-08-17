<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\PipeFilters\StringEndsWith;

/**
 * @group EndsWith
 */
class EndsWithTest extends TestCase
{
    /**
     * @test
     */
    public function string()
    {
        $using = "Do you remember when, we using to sing?";

        $this->start = hrtime(true);
        $expected = true;

        $actual = StringEndsWith::applyWith("sing?")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 4.5);

        $this->start = hrtime(true);
        $expected = false;

        $actual = StringEndsWith::applyWith("Do you...")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 2.9);
    }
}
