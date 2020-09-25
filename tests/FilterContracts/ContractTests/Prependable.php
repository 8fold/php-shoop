<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shooped;

trait Prependable
{
    /**
     * @test
     * @group Prependable
     * @group 1.0.0
     */
    public function prepend()
    {
        // AssertEquals::applyWith(
        //     true,
        //     "boolean",
        //     0.001,
        //     1
        // )->unfoldUsing(
        //     Shooped::fold(false)->prepend(1)
        // );

        // AssertEquals::applyWith(
        //     false,
        //     "boolean",
        //     0.001,
        //     1
        // )->unfoldUsing(
        //     Shooped::fold(false)->prepend(false)
        // );

        // AssertEquals::applyWith(
        //     2,
        //     "integer",
        //     0.001,
        //     1
        // )->unfoldUsing(
        //     Shooped::fold(1)->prepend(1)
        // );

        // AssertEquals::applyWith(
        //     0.5,
        //     "double",
        //     0.001,
        //     1
        // )->unfoldUsing(
        //     Shooped::fold(1.5)->prepend(-1)
        // );

        AssertEquals::applyWith(
            [2, 3, 1],
            "array",
            21.32, // 6,
            257 // 256 // 255
        )->unfoldUsing(
            Shooped::fold([1])->prepend([2, 3])
        );

        AssertEquals::applyWith(
            "!8fold",
            "string",
            1.21, // 0.9,
            6
        )->unfoldUsing(
            Shooped::fold("8fold")->prepend("!")
        );

        AssertEquals::applyWith(
            (object) ["b" => 2, "c" => 3, "a" => 1],
            "object",
            2.23,
            121
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1])->prepend(["b" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            (object) ["a" => 2, "c" => 3],
            "object",
            0.07, // 0.05,
            1
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1])->prepend((object) ["a" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            (object) ["a" => 1, "0.0" => 3],
            "object",
            0.58,
            10
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1])->prepend(3)
        );

        // TODO: Objects
    }
}
