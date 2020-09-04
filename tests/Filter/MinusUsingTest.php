<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Filter\MinusUsing;

/**
 * @group Minus
 * @group MinusUsing
 */
class MinusUsingTest extends TestCase
{
    /**
     * @test
     */
    public function boolean()
    {
    }

    /**
     * @test
     */
    public function number()
    {
    }

    /**
     * @test
     */
    public function lists()
    {
        AssertEquals::applyWith(
            ["8fold", "!"],
            "array",
            0.86 // 0.8 // 0.79
        )->unfoldUsing(
            MinusUsing::apply()->unfoldUsing([null, "8fold", false, "", "!"])
        );

        AssertEquals::applyWith(
            [false],
            "array"
        )->unfoldUsing(
            MinusUsing::applyWith("is_bool")
                ->unfoldUsing([null, "8fold", false, "", "!"])
        );

        AssertEquals::applyWith(
            [null],
            "array"
        )->unfoldUsing(
            MinusUsing::applyWith(function ($v) { return is_null($v); })
                ->unfoldUsing([null, "8fold", false, "", "!"])
        );
    }

    /**
     * @test
     */
    public function string()
    {
    }


    /**
     * @test
     */
    public function tuples()
    {
    }
}
