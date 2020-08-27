<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Shoop\Tests\TestClasses\AssertEqualsFluent;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Shooped;

trait Stringable
{
    /**
     * @test
     */
    public function asString()
    {
        AssertEqualsFluent::applyWith(
            "true",
            Shooped::class,
            10.05 // 6.48
        )->unfoldUsing(
            Shooped::fold(true)->asString()
        );

        AssertEqualsFluent::applyWith(
            "3",
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(3)->asString()
        );

        AssertEqualsFluent::applyWith(
            "2.5",
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(2.5)->asString()
        );

        AssertEqualsFluent::applyWith(
            "Hi!",
            Shooped::class,
            1.62
        )->unfoldUsing(
            Shooped::fold(["H", 1, "i", true, "!"])->asString()
        );

        AssertEqualsFluent::applyWith(
            "",
            Shooped::class,
            0.91
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->asString()
        );

        AssertEqualsFluent::applyWith(
            "8fold!",
            Shooped::class,
            4.05
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "b" => "8fold!", "c" => 3])->asString()
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function efToString()
    {
        AssertEqualsFluent::applyWith(
            "true",
            "string",
            2.24 // 2.04 // 1.65
        )->unfoldUsing(
            Shooped::fold(true)->efToString()
        );

        AssertEqualsFluent::applyWith(
            "3",
            "string"
        )->unfoldUsing(
            Shooped::fold(3)->efToString()
        );

        AssertEqualsFluent::applyWith(
            "2.5",
            "string"
        )->unfoldUsing(
            Shooped::fold(2.5)->efToString()
        );

        AssertEqualsFluent::applyWith(
            "Hi!",
            "string",
            1.64
        )->unfoldUsing(
            Shooped::fold(["H", 1, "i", true, "!"])->efToString()
        );

        AssertEqualsFluent::applyWith(
            "",
            "string",
            0.91
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->efToString()
        );

        AssertEqualsFluent::applyWith(
            "8fold!",
            "string",
            2.18
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "b" => "8fold!", "c" => 3])->efToString()
        );

        // TODO: Objects
    }
}
