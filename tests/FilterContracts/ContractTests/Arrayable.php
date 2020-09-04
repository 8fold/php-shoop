<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shooped;

trait Arrayable
{
    /**
     * @test
     */
    public function asArray()
    {
        AssertEquals::applyWith(
            [false, true],
            "array",
            7.86 // 7.21 // 2.15 // 2.01 // 1.77
        )->unfoldUsing(
            Shooped::fold(true)->asArray()
        );

        // TODO: Should arrays start at 1
        AssertEquals::applyWith(
            // [1 => 2, 2 => 3]
            [2, 3],
            "array",
            0.91 // 0.51
        )->unfoldUsing(
            Shooped::fold(3)->asArray(2)
        );

        // TODO: Should arrays start at 1
        AssertEquals::applyWith(
            // [1 => 1, 2 => 2]
            [0, 1, 2],
            "array"
        )->unfoldUsing(
            Shooped::fold(2.5)->asArray()
        );

        AssertEquals::applyWith(
            [3, 1, 3],
            "array"
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->asArray()
        );

        AssertEquals::applyWith(
            [1, 3, 1],
            "array",
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->asArray()
        );

        AssertEquals::applyWith(
            ["H", "i", "!"],
            "array"
        )->unfoldUsing(
            Shooped::fold("Hi!")->asArray()
        );

        AssertEquals::applyWith(
            ["", "H", "i", ""],
            "array"
        )->unfoldUsing(
            Shooped::fold("!H!i!")->asArray("!")
        );

        AssertEquals::applyWith(
            ["H", "i"],
            "array"
        )->unfoldUsing(
            Shooped::fold("!H!i!")->asArray("!", false)
        );

        AssertEquals::applyWith(
            ["", "H!i!"],
            "array"
        )->unfoldUsing(
            Shooped::fold("!H!i!")->asArray("!", true, 2)
        );

        AssertEquals::applyWith(
            ["H!i!"],
            "array"
        )->unfoldUsing(
            Shooped::fold("!H!i!")->asArray("!", false, 2)
        );

        AssertEquals::applyWith(
            [1, 3],
            "array",
            3.01 // 1.87 // 0.93 // 0.88
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->asArray()
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function efToArray()
    {
        AssertEquals::applyWith(
            [false, true],
            "array"
        )->unfoldUsing(
            Shooped::fold(true)->efToArray()
        );

        // TODO: Should arrays start at 1
        AssertEquals::applyWith(
            // [1 => 2, 2 => 3]
            [0, 1, 2, 3],
            "array"
        )->unfoldUsing(
            Shooped::fold(3)->efToArray()
        );

        // TODO: Should arrays start at 1
        AssertEquals::applyWith(
            // [1 => 1, 2 => 2]
            [0, 1, 2],
            "array"
        )->unfoldUsing(
            Shooped::fold(2.5)->efToArray()
        );

        AssertEquals::applyWith(
            [3, 1, 3],
            "array"
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->efToArray()
        );

        AssertEquals::applyWith(
            [1, 3, 1],
            "array"
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->efToArray()
        );

        AssertEquals::applyWith(
            ["H", "i", "!"],
            "array"
        )->unfoldUsing(
            Shooped::fold("Hi!")->efToArray()
        );

        AssertEquals::applyWith(
            [1, 3],
            "array",
            2.23 // 1.84
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->efToArray()
        );

        // TODO: Objects
    }
}
