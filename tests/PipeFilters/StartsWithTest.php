<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\PipeFilters\StringStartsWith;

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

        $this->start = hrtime(true);
        $expected = true;

        $actual = StringStartsWith::applyWith("Do you")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 3.8);

        $this->start = hrtime(true);
        $expected = false;

        $actual = StringStartsWith::applyWith("Do you...")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 2.9);
    }
}
