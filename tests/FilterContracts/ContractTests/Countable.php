<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shooped;

/**
 * @version 1.0.0
 */
trait Countable
{
    /**
     * @test
     */
    public function asInteger()
    {
        AssertEquals::applyWith(
            1,
            "integer",
            2.85, // 2.79, // 2.72, // 2.7, // 2.68, // 2.6,
            218
        )->unfoldUsing(
            Shooped::fold(true)->asInteger()
        );

        AssertEquals::applyWith(
            3,
            "integer",
            0.15,
            4
        )->unfoldUsing(
            Shooped::fold(3)->asInteger()
        );

        AssertEquals::applyWith(
            3,
            "integer",
            0.02,
            1
        )->unfoldUsing(
            Shooped::fold(2.5)->asInteger()
        );

        AssertEquals::applyWith(
            1,
            "integer",
            0.09,
            2
        )->unfoldUsing(
            Shooped::fold([3, 1, 3, 1])->asInteger()
        );

        AssertEquals::applyWith(
            1,
            "integer",
            0.02,
            1
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->asInteger()
        );

        AssertEquals::applyWith(
            0,
            "integer",
            0.09,
            4
        )->unfoldUsing(
            Shooped::fold("Hi!")->asInteger()
        );

        AssertEquals::applyWith(
            1,
            "integer",
            0.53, // 0.49, // 0.43,
            29
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->asInteger()
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function efToInteger()
    {
        AssertEquals::applyWith(
            1,
            "integer",
            3.1, // 2.77, // 2.5, // 2.49,
            218
        )->unfoldUsing(
            Shooped::fold(true)->efToInteger()
        );

        AssertEquals::applyWith(
            3,
            "integer",
            0.25, // 0.18, // 0.16, // 0.15, // 0.14,
            4
        )->unfoldUsing(
            Shooped::fold(3)->efToInteger()
        );

        AssertEquals::applyWith(
            3,
            "integer",
            0.02,
            1
        )->unfoldUsing(
            Shooped::fold(2.5)->efToInteger()
        );

        AssertEquals::applyWith(
            1,
            "integer",
            0.08, // 0.02, // 0.08, // 0.07,
            1
        )->unfoldUsing(
            Shooped::fold([3, 1, 3, 1])->efToInteger()
        );

        AssertEquals::applyWith(
            1,
            "integer",
            0.02,
            1
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->efToInteger()
        );

        AssertEquals::applyWith(
            0,
            "integer",
            0.19, // 0.11, // 0.09,
            4
        )->unfoldUsing(
            Shooped::fold("Hi!")->efToInteger()
        );

        AssertEquals::applyWith(
            1,
            "integer",
            0.63, // 0.5,
            29
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->efToInteger()
        );

        // TODO: Objects
    }
}
