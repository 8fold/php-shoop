<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Filter\Reversed;

/**
 * @group Reversed
 */
class ReversedTest extends TestCase
{
    /**
     * @test
     */
    public function numbers()
    {
        AssertEquals::applyWith(
            -1,
            "integer",
            1.99,
            13
        )->unfoldUsing(
            Reversed::fromNumber(1)
        );

        AssertEquals::applyWith(
            1.0,
            "double",
            0.002,
            1
        )->unfoldUsing(
            Reversed::fromNumber(-1.0)
        );
    }

    /**
     * @test
     */
    public function strings()
    {
        AssertEquals::applyWith(
            "8fold!",
            "string",
            0.41, // 0.36,
            24
        )->unfoldUsing(
            Reversed::fromString("!dlof8")
        );

        AssertEquals::applyWith(
            "👆👆👍👇👇",
            "string",
            0.004,
            1
        )->unfoldUsing(
            Reversed::fromString("👇👇👍👆👆")
        );

        AssertEquals::applyWith(
            "👆👆👇👇",
            "string",
            0.003,
            1
        )->unfoldUsing(
            Reversed::fromString("👇👇👆👆")
        );
    }
}
