<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shooped;

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
            5.28,
            64
        )->unfoldUsing(
            Shooped::fold(true)->asInteger()
        );

        AssertEquals::applyWith(
            3,
            "integer",
            0.94
        )->unfoldUsing(
            Shooped::fold(3)->asInteger()
        );

        AssertEquals::applyWith(
            2,
            "integer"
        )->unfoldUsing(
            Shooped::fold(2.5)->asInteger()
        );

        AssertEquals::applyWith(
            4,
            "integer",
            0.61
        )->unfoldUsing(
            Shooped::fold([3, 1, 3, 1])->asInteger()
        );

        AssertEquals::applyWith(
            3,
            "integer",
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->asInteger()
        );

        AssertEquals::applyWith(
            3,
            "integer"
        )->unfoldUsing(
            Shooped::fold("Hi!")->asInteger()
        );

        AssertEquals::applyWith(
            2,
            "integer"
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
            1.93,
            64
        )->unfoldUsing(
            Shooped::fold(true)->efToInteger()
        );

        AssertEquals::applyWith(
            3,
            "integer"
        )->unfoldUsing(
            Shooped::fold(3)->efToInteger()
        );

        AssertEquals::applyWith(
            2,
            "integer"
        )->unfoldUsing(
            Shooped::fold(2.5)->efToInteger()
        );

        AssertEquals::applyWith(
            4,
            "integer"
        )->unfoldUsing(
            Shooped::fold([3, 1, 3, 1])->efToInteger()
        );

        AssertEquals::applyWith(
            3,
            "integer"
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->efToInteger()
        );

        AssertEquals::applyWith(
            3,
            "integer"
        )->unfoldUsing(
            Shooped::fold("Hi!")->efToInteger()
        );

        AssertEquals::applyWith(
            2,
            "integer"
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->efToInteger()
        );

        // TODO: Objects
    }
}
