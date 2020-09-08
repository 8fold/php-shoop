<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Filter\EndsWith;

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

        AssertEquals::applyWith(
            true,
            "boolean",
            6.91, // 6.16
            136 // 71
        )->unfoldUsing(
            EndsWith::applyWith("sing?")->unfoldUsing($using)
        );

        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            EndsWith::applyWith("Do you...")->unfoldUsing($using)
        );
    }
}
