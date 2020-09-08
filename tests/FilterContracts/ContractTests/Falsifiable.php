<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shooped;

trait Falsifiable
{
    /**
     * @test
     */
    public function asBoolean()
    {
        AssertEquals::applyWith(
            true,
            "boolean",
            2.3
        )->unfoldUsing(
            Shooped::fold(true)->asBoolean()
        );

        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(0)->asBoolean()
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(2.5)->asBoolean()
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.69
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->asBoolean()
        );

        AssertEquals::applyWith(
            false,
            "boolean",
        )->unfoldUsing(
            Shooped::fold([])->asBoolean()
        );

        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold("")->asBoolean()
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.88
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->asBoolean()
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function efToBoolean()
    {
        AssertEquals::applyWith(
            true,
            "boolean",
            2.5
        )->unfoldUsing(
            Shooped::fold(true)->efToBoolean()
        );

        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(0)->efToBoolean()
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(2.5)->efToBoolean()
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.7
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->efToBoolean()
        );

        AssertEquals::applyWith(
            false,
            "boolean",
        )->unfoldUsing(
            Shooped::fold([])->efToBoolean()
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.44
        )->unfoldUsing(
            Shooped::fold("")->efToBoolean()
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.88
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->efToBoolean()
        );

        // TODO: Objects
    }
}
