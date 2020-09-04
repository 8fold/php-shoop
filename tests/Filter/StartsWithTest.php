<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use \stdClass;

use Eightfold\Shoop\Filter\StartsWith;

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
            "boolean",
            3.1
        )->unfoldUsing(
            StartsWith::applyWith("Do you")->unfoldUsing($using)
        );

        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            StartsWith::applyWith("Do you...")->unfoldUsing($using)
        );
    }
}
