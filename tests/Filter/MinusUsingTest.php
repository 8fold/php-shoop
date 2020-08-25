<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;
use Eightfold\Shoop\Tests\AssertEquals;

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
            MinusUsing::apply(),
            0.51
        )->unfoldUsing([null, "8fold", false, "", "!"]);

        AssertEquals::applyWith(
            [false],
            MinusUsing::applyWith("is_bool")
        )->unfoldUsing([null, "8fold", false, "", "!"]);

        AssertEquals::applyWith(
            [null],
            MinusUsing::applyWith(function ($v) { return is_null($v); })
        )->unfoldUsing([null, "8fold", false, "", "!"]);
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
