<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Shoop\Tests\TestClasses\AssertEqualsFluent;

use Eightfold\Shoop\Shooped;

trait Arrayable
{
    /**
     * @test
     */
    public function asArray()
    {
        AssertEqualsFluent::applyWith(
            [false, true],
            Shooped::class,
            7.86 // 7.21 // 2.15 // 2.01 // 1.77
        )->unfoldUsing(
            Shooped::fold(true)->asArray()
        );

        // TODO: Should arrays start at 1
        AssertEqualsFluent::applyWith(
            // [1 => 2, 2 => 3]
            [2, 3],
            Shooped::class,
            0.91 // 0.51
        )->unfoldUsing(
            Shooped::fold(3)->asArray(2)
        );

        // TODO: Should arrays start at 1
        AssertEqualsFluent::applyWith(
            // [1 => 1, 2 => 2]
            [0, 1, 2],
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(2.5)->asArray()
        );

        AssertEqualsFluent::applyWith(
            [3, 1, 3],
            Shooped::class
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->asArray()
        );

        AssertEqualsFluent::applyWith(
            [1, 3, 1],
            Shooped::class,
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->asArray()
        );

        AssertEqualsFluent::applyWith(
            ["H", "i", "!"],
            Shooped::class
        )->unfoldUsing(
            Shooped::fold("Hi!")->asArray()
        );

        AssertEqualsFluent::applyWith(
            ["", "H", "i", ""],
            Shooped::class
        )->unfoldUsing(
            Shooped::fold("!H!i!")->asArray("!")
        );

        AssertEqualsFluent::applyWith(
            ["H", "i"],
            Shooped::class
        )->unfoldUsing(
            Shooped::fold("!H!i!")->asArray("!", false)
        );

        AssertEqualsFluent::applyWith(
            ["", "H!i!"],
            Shooped::class
        )->unfoldUsing(
            Shooped::fold("!H!i!")->asArray("!", true, 2)
        );

        AssertEqualsFluent::applyWith(
            ["H!i!"],
            Shooped::class
        )->unfoldUsing(
            Shooped::fold("!H!i!")->asArray("!", false, 2)
        );

        AssertEqualsFluent::applyWith(
            [1, 3],
            Shooped::class,
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
        AssertEqualsFluent::applyWith(
            [false, true],
            "array"
        )->unfoldUsing(
            Shooped::fold(true)->efToArray()
        );

        // TODO: Should arrays start at 1
        AssertEqualsFluent::applyWith(
            // [1 => 2, 2 => 3]
            [0, 1, 2, 3],
            "array"
        )->unfoldUsing(
            Shooped::fold(3)->efToArray()
        );

        // TODO: Should arrays start at 1
        AssertEqualsFluent::applyWith(
            // [1 => 1, 2 => 2]
            [0, 1, 2],
            "array"
        )->unfoldUsing(
            Shooped::fold(2.5)->efToArray()
        );

        AssertEqualsFluent::applyWith(
            [3, 1, 3],
            "array"
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->efToArray()
        );

        AssertEqualsFluent::applyWith(
            [1, 3, 1],
            "array"
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->efToArray()
        );

        AssertEqualsFluent::applyWith(
            ["H", "i", "!"],
            "array"
        )->unfoldUsing(
            Shooped::fold("Hi!")->efToArray()
        );

        AssertEqualsFluent::applyWith(
            [1, 3],
            "array",
            2.23 // 1.84
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->efToArray()
        );

        // TODO: Objects
    }
}
