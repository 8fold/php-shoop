<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Shooped;

trait Stringable
{
    /**
     * @test
     */
    public function asString()
    {
        AssertEquals::applyWith(
            "true",
            "string",
            10.05 // 6.48
        )->unfoldUsing(
            Shooped::fold(true)->asString()
        );

        AssertEquals::applyWith(
            "3",
            "string"
        )->unfoldUsing(
            Shooped::fold(3)->asString()
        );

        AssertEquals::applyWith(
            "2.5",
            "string"
        )->unfoldUsing(
            Shooped::fold(2.5)->asString()
        );

        AssertEquals::applyWith(
            "Hi!",
            "string",
            1.62
        )->unfoldUsing(
            Shooped::fold(["H", 1, "i", true, "!"])->asString()
        );

        AssertEquals::applyWith(
            "",
            "string",
            0.91
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->asString()
        );

        AssertEquals::applyWith(
            "8fold!",
            "string",
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
        AssertEquals::applyWith(
            "true",
            "string",
            2.24 // 2.04 // 1.65
        )->unfoldUsing(
            Shooped::fold(true)->efToString()
        );

        AssertEquals::applyWith(
            "3",
            "string"
        )->unfoldUsing(
            Shooped::fold(3)->efToString()
        );

        AssertEquals::applyWith(
            "2.5",
            "string"
        )->unfoldUsing(
            Shooped::fold(2.5)->efToString()
        );

        AssertEquals::applyWith(
            "Hi!",
            "string",
            1.64
        )->unfoldUsing(
            Shooped::fold(["H", 1, "i", true, "!"])->efToString()
        );

        AssertEquals::applyWith(
            "",
            "string",
            0.91
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->efToString()
        );

        AssertEquals::applyWith(
            "8fold!",
            "string",
            2.18
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "b" => "8fold!", "c" => 3])->efToString()
        );

        // TODO: Objects
    }
}
