<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Shoop\Tests\TestClasses\AssertEqualsFluent;

use Eightfold\Shoop\Shooped;

trait Falsifiable
{
    /**
     * @test
     */
    public function asBoolean()
    {
        AssertEqualsFluent::applyWith(
            true,
            Shooped::class,
            2.3
        )->unfoldUsing(
            Shooped::fold(true)->asBoolean()
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(0)->asBoolean()
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(2.5)->asBoolean()
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class,
            0.69
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->asBoolean()
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class,
        )->unfoldUsing(
            Shooped::fold([])->asBoolean()
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold("")->asBoolean()
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class,
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
        AssertEqualsFluent::applyWith(
            true,
            "boolean",
            2.5
        )->unfoldUsing(
            Shooped::fold(true)->efToBoolean()
        );

        AssertEqualsFluent::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(0)->efToBoolean()
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(2.5)->efToBoolean()
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean",
            0.7
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->efToBoolean()
        );

        AssertEqualsFluent::applyWith(
            false,
            "boolean",
        )->unfoldUsing(
            Shooped::fold([])->efToBoolean()
        );

        AssertEqualsFluent::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold("")->efToBoolean()
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean",
            0.88
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->efToBoolean()
        );

        // TODO: Objects
    }
}
