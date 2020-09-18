<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Shooped;

/**
 * @version 1.0.0
 */
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
            2.56, // 2.55, // 2.48, // 2.33, // 2.23,
            209
        )->unfoldUsing(
            Shooped::fold(true)->asString()
        );

        AssertEquals::applyWith(
            "3.0",
            "string",
            0.17, // 0.16, // 0.15,
            4
        )->unfoldUsing(
            Shooped::fold(3)->asString()
        );

        AssertEquals::applyWith(
            "2.5",
            "string",
            0.02,
            1
        )->unfoldUsing(
            Shooped::fold(2.5)->asString()
        );

        AssertEquals::applyWith(
            "Hi!",
            "string",
            0.07,
            2
        )->unfoldUsing(
            Shooped::fold(["H", 1, "i", true, "!"])->asString()
        );

        AssertEquals::applyWith(
            "",
            "string",
            0.03, // 0.02,
            1
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->asString()
        );

        AssertEquals::applyWith(
            "8fold!",
            "string",
            0.57, // 0.56, // 0.51,
            34
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
            13.92, // 2.58, // 2.3,
            209
        )->unfoldUsing(
            Shooped::fold(true)->efToString()
        );

        AssertEquals::applyWith(
            "3.0",
            "string",
            2.28, // 0.17, // 0.16, // 0.15,
            4
        )->unfoldUsing(
            Shooped::fold(3)->efToString()
        );

        AssertEquals::applyWith(
            "2.5",
            "string",
            0.05, // 0.02,
            1
        )->unfoldUsing(
            Shooped::fold(2.5)->efToString()
        );

        AssertEquals::applyWith(
            "Hi!",
            "string",
            0.42, // 0.07,
            1
        )->unfoldUsing(
            Shooped::fold(["H", 1, "i", true, "!"])->efToString()
        );

        AssertEquals::applyWith(
            "",
            "string",
            0.02,
            1
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->efToString()
        );

        AssertEquals::applyWith(
            "8fold!",
            "string",
            3.52, // 0.58,
            33
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "b" => "8fold!", "c" => 3])->efToString()
        );

        // TODO: Objects
    }
}
