<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;
use Eightfold\Shoop\Tests\AssertEquals;

use \stdClass;

use Eightfold\Shoop\PipeFilters\StartsWith;

/**
 * @group StartsWith
 */
class StartsWithTest extends TestCase
{
    /**
     * @test
     */
    public function string()
    {
        $using = "Do you remember when, we using to sing?";

        AssertEquals::applyWith(
            true,
            StartsWith::applyWith("Do you")
        )->unfoldUsing($using);


        // $this->start = hrtime(true);
        // $expected = true;

        // $actual = StartsWith::applyWith("Do you")->unfoldUsing($using);
        // $this->assertEqualsWithPerformance($expected, $actual, 3.8);

        // $this->start = hrtime(true);
        // $expected = false;

        // $actual = StartsWith::applyWith("Do you...")->unfoldUsing($using);
        // $this->assertEqualsWithPerformance($expected, $actual, 2.9);
    }
}
