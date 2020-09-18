<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shooped;

/**
 * @group current
 */
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
            14.66, // 5.05,
            234
        )->unfoldUsing(
            Shooped::fold(true)->asBoolean()
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            1.36, // 0.2, // 0.18, // 0.14,
            4
        )->unfoldUsing(
            Shooped::fold(0)->asBoolean()
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.02,
            1
        )->unfoldUsing(
            Shooped::fold(2.5)->asBoolean()
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.82, // 0.08, // 0.07,
            2
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->asBoolean()
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.02,
            1
        )->unfoldUsing(
            Shooped::fold([])->asBoolean()
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.81, // 0.09, // 0.08,
            4
        )->unfoldUsing(
            Shooped::fold("")->asBoolean()
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            3.44, // 0.51, // 0.47,
            29
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
            3.19, // 2.88, // 2.52,
            234
        )->unfoldUsing(
            Shooped::fold(true)->efToBoolean()
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.19, // 0.16, // 0.14,
            4
        )->unfoldUsing(
            Shooped::fold(0)->efToBoolean()
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.02,
            1
        )->unfoldUsing(
            Shooped::fold(2.5)->efToBoolean()
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.11, // 0.07,
            1
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->efToBoolean()
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.02,
            1
        )->unfoldUsing(
            Shooped::fold([])->efToBoolean()
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.1, // 0.09,
            4
        )->unfoldUsing(
            Shooped::fold("")->efToBoolean()
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.6,
            29
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->efToBoolean()
        );

        // TODO: Objects
    }
}
