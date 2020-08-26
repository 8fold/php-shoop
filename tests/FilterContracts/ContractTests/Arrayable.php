<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Shoop\Tests\AssertEqualsFluent;

use Eightfold\Shoop\Tests\FilterContracts\ClassShooped;

trait Arrayable
{
    /**
     * @test
     */
    public function asArray()
    {
        AssertEqualsFluent::applyWith(
            [false, true],
            ClassShooped::class,
            7.86 // 7.21 // 2.15 // 2.01 // 1.77
        )->unfoldUsing(
            ClassShooped::fold(true)->asArray()
        );

        // TODO: Should arrays start at 1
        AssertEqualsFluent::applyWith(
            // [1 => 2, 2 => 3]
            [2, 3],
            ClassShooped::class,
        )->unfoldUsing(
            ClassShooped::fold(3)->asArray(2)
        );

        // TODO: Should arrays start at 1
        AssertEqualsFluent::applyWith(
            // [1 => 1, 2 => 2]
            [0, 1, 2],
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold(2.5)->asArray()
        );

        AssertEqualsFluent::applyWith(
            [3, 1, 3],
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold([3, 1, 3])->asArray()
        );

        AssertEqualsFluent::applyWith(
            [1, 3, 1],
            ClassShooped::class,
        )->unfoldUsing(
            ClassShooped::fold(["a" => 1, "b" => 3, "c" => 1])->asArray()
        );

        AssertEqualsFluent::applyWith(
            ["H", "i", "!"],
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold("Hi!")->asArray()
        );

        AssertEqualsFluent::applyWith(
            ["", "H", "i", ""],
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold("!H!i!")->asArray("!")
        );

        AssertEqualsFluent::applyWith(
            ["H", "i"],
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold("!H!i!")->asArray("!", false)
        );

        AssertEqualsFluent::applyWith(
            ["", "H!i!"],
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold("!H!i!")->asArray("!", true, 2)
        );

        AssertEqualsFluent::applyWith(
            ["H!i!"],
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold("!H!i!")->asArray("!", false, 2)
        );

        AssertEqualsFluent::applyWith(
            [1, 3],
            ClassShooped::class,
            0.88
        )->unfoldUsing(
            ClassShooped::fold((object) ["a" => 1, "c" => 3])->asArray()
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
            ClassShooped::fold(true)->efToArray()
        );

        // TODO: Should arrays start at 1
        AssertEqualsFluent::applyWith(
            // [1 => 2, 2 => 3]
            [0, 1, 2, 3],
            "array"
        )->unfoldUsing(
            ClassShooped::fold(3)->efToArray()
        );

        // TODO: Should arrays start at 1
        AssertEqualsFluent::applyWith(
            // [1 => 1, 2 => 2]
            [0, 1, 2],
            "array"
        )->unfoldUsing(
            ClassShooped::fold(2.5)->efToArray()
        );

        AssertEqualsFluent::applyWith(
            [3, 1, 3],
            "array"
        )->unfoldUsing(
            ClassShooped::fold([3, 1, 3])->efToArray()
        );

        AssertEqualsFluent::applyWith(
            [1, 3, 1],
            "array"
        )->unfoldUsing(
            ClassShooped::fold(["a" => 1, "b" => 3, "c" => 1])->efToArray()
        );

        AssertEqualsFluent::applyWith(
            ["H", "i", "!"],
            "array"
        )->unfoldUsing(
            ClassShooped::fold("Hi!")->efToArray()
        );

        AssertEqualsFluent::applyWith(
            [1, 3],
            "array",
            1.84
        )->unfoldUsing(
            ClassShooped::fold((object) ["a" => 1, "c" => 3])->efToArray()
        );

        // TODO: Objects
    }
}
