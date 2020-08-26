<?php

namespace Eightfold\Shoop\Tests\PipeFilters\Contracts;

use Eightfold\Shoop\Tests\FilterContracts\FilterContractsTestCase;
use Eightfold\Shoop\Tests\AssertEqualsFluent;

use Eightfold\Shoop\Tests\FilterContracts\ClassShooped;

/**
 * @group Shooped
 */
class ShoopedTest extends FilterContractsTestCase
{
    static public function sutClassName(): string
    {
        return ClassShooped::class;
    }

    /**
     * @test
     */
    public function fold()
    {
        $expected = false;
        $instance = ClassShooped::fold($expected);
        $actual   = $instance->args(true)[0];
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function unfold()
    {
        $expected = true;
        $actual   = ClassShooped::fold($expected)->unfold();
        $this->assertEquals($expected, $actual);
    }

// - Maths

    /**
     * @test
     */
    public function plus()
    {
        AssertEqualsFluent::applyWith(
            true,
            ClassShooped::class,
            11.96 // 5.62 // 2.98 // 2.94 // 2.89 // 2.18 // 1.54
        )->unfoldUsing(
            ClassShooped::fold(false)->plus(1)
        );

        AssertEqualsFluent::applyWith(
            2,
            ClassShooped::class,
            7.26 // 2.55 // 2.54 // 2.48
        )->unfoldUsing(
            ClassShooped::fold(1)->plus(1)
        );

        AssertEqualsFluent::applyWith(
            2.5,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold(1.5)->plus(1)
        );

        AssertEqualsFluent::applyWith(
            [1, 2, 3],
            ClassShooped::class,
            0.52
        )->unfoldUsing(
            ClassShooped::fold([1])->plus([2, 3])
        );

        AssertEqualsFluent::applyWith(
            (object) ["a" => 1, "b" => 2, "c" => 3],
            ClassShooped::class,
            1.1 // 0.99 // 0.82
        )->unfoldUsing(
            ClassShooped::fold((object) ["a" => 1])->plus(["b" => 2, "c" => 3])
        );

        AssertEqualsFluent::applyWith(
            (object) ["a" => 1, "b" => 2, "c" => 3],
            ClassShooped::class,
            0.49
        )->unfoldUsing(
            ClassShooped::fold((object) ["a" => 1])->plus((object) ["b" => 2, "c" => 3])
        );

        AssertEqualsFluent::applyWith(
            (object) ["a" => 1, "i0" => 3],
            ClassShooped::class,
            0.49
        )->unfoldUsing(
            ClassShooped::fold((object) ["a" => 1])->plus(3)
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function minus()
    {
        AssertEqualsFluent::applyWith(
            false,
            ClassShooped::class,
            20.64 // 2.84 // 2.24 // 0.97
        )->unfoldUsing(
            ClassShooped::fold(true)->minus(1)
        );

        AssertEqualsFluent::applyWith(
            0,
            ClassShooped::class,
        )->unfoldUsing(
            ClassShooped::fold(1)->minus(1)
        );

        AssertEqualsFluent::applyWith(
            0.5,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold(1.5)->minus(1)
        );

        AssertEqualsFluent::applyWith(
            [],
            ClassShooped::class,
            1.14
        )->unfoldUsing(
            ClassShooped::fold([3, 1, 3])->minus(3)
        );

        AssertEqualsFluent::applyWith(
            [1],
            ClassShooped::class,
        )->unfoldUsing(
            ClassShooped::fold([3, 1, 3])->minus(1)
        );

        AssertEqualsFluent::applyWith(
            [3, 1],
            ClassShooped::class,
            2.03
        )->unfoldUsing(
            ClassShooped::fold([3, 1, 3])->minus(1, false)
        );

        AssertEqualsFluent::applyWith(
            [1, 3],
            ClassShooped::class,
        )->unfoldUsing(
            ClassShooped::fold([3, 1, 3])->minus(1, true, false)
        );

        AssertEqualsFluent::applyWith(
            [1, 1, 1],
            ClassShooped::class,
        )->unfoldUsing(
            ClassShooped::fold([1, 3, 1, 3, 1])->minus(3, false, false)
        );

        AssertEqualsFluent::applyWith(
            ["b" => 3],
            ClassShooped::class,
        )->unfoldUsing(
            ClassShooped::fold(["a" => 1, "b" => 3, "c" => 1])->minus(1, false, false)
        );

        $using = <<<EOD

            Hello!


        EOD;
        AssertEqualsFluent::applyWith(
            "Hello!",
            ClassShooped::class,
            1.6
        )->unfoldUsing(
            ClassShooped::fold($using)->minus()
        );

        AssertEqualsFluent::applyWith(
            "He!",
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold("Hello!")->minus(["l", "o"], false, false)
        );

        AssertEqualsFluent::applyWith(
            (object) ["a" => 1],
            ClassShooped::class,
            0.83 // 0.35
        )->unfoldUsing(
            ClassShooped::fold((object) ["a" => 1, "c" => 3])->minus(3, false, false)
        );

        // TODO: Objects
    }

// - Arrayable

    /**
     * @test
     */
    public function asArray()
    {
        AssertEqualsFluent::applyWith(
            [false, true],
            ClassShooped::class,
            2.15 // 2.01 // 1.77
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
            "array"
        )->unfoldUsing(
            ClassShooped::fold((object) ["a" => 1, "c" => 3])->efToArray()
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function asDictionary()
    {
        AssertEqualsFluent::applyWith(
            // if no 0 - [true, false]
            ["false" => false, "true" => true],
            ClassShooped::class,
            2.47
        )->unfoldUsing(
            ClassShooped::fold(true)->asDictionary()
        );

        // TODO: Should arrays start at 1
        AssertEqualsFluent::applyWith(
            // ["i1" => 1, "i2" => 2, "i3" => 3]
            ["i0" => 0, "i1" => 1, "i2" => 2, "i3" => 3],
            ClassShooped::class,
            3.98
        )->unfoldUsing(
            ClassShooped::fold(3)->asDictionary()
        );

        // TODO: Should arrays start at 1
        AssertEqualsFluent::applyWith(
            // ["i1" => 1, "i2" => 2]
            ["i0" => 0, "i1" => 1, "i2" => 2],
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold(2.5)->asDictionary()
        );

        AssertEqualsFluent::applyWith(
            ["i0" => 3, "i1" => 1, "i2" => 3],
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold([3, 1, 3])->asDictionary()
        );

        AssertEqualsFluent::applyWith(
            ["a" => 1, "b" => 3, "c" => 1],
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold(["a" => 1, "b" => 3, "c" => 1])->asDictionary()
        );

        AssertEqualsFluent::applyWith(
            ["content" => "Hi!"],
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold("Hi!")->asDictionary()
        );

        AssertEqualsFluent::applyWith(
            ["a" => 1, "c" => 3],
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold((object) ["a" => 1, "c" => 3])->asDictionary()
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function efToDictionary()
    {
        AssertEqualsFluent::applyWith(
            // if no 0 - [true, false]
            ["false" => false, "true" => true],
            "array",
            2.05
        )->unfoldUsing(
            ClassShooped::fold(true)->efToDictionary()
        );

        // TODO: Should arrays start at 1
        AssertEqualsFluent::applyWith(
            // ["i1" => 1, "i2" => 2, "i3" => 3]
            ["i0" => 0, "i1" => 1, "i2" => 2, "i3" => 3],
            "array",
            0.92
        )->unfoldUsing(
            ClassShooped::fold(3)->efToDictionary()
        );

        // TODO: Should arrays start at 1
        AssertEqualsFluent::applyWith(
            // ["i1" => 1, "i2" => 2]
            ["i0" => 0, "i1" => 1, "i2" => 2],
            "array"
        )->unfoldUsing(
            ClassShooped::fold(2.5)->efToDictionary()
        );

        AssertEqualsFluent::applyWith(
            ["i0" => 3, "i1" => 1, "i2" => 3],
            "array"
        )->unfoldUsing(
            ClassShooped::fold([3, 1, 3])->efToDictionary()
        );

        AssertEqualsFluent::applyWith(
            ["a" => 1, "b" => 3, "c" => 1],
            "array"
        )->unfoldUsing(
            ClassShooped::fold(["a" => 1, "b" => 3, "c" => 1])->efToDictionary()
        );

        AssertEqualsFluent::applyWith(
            ["content" => "Hi!"],
            "array"
        )->unfoldUsing(
            ClassShooped::fold("Hi!")->efToDictionary()
        );

        AssertEqualsFluent::applyWith(
            ["a" => 1, "c" => 3],
            "array"
        )->unfoldUsing(
            ClassShooped::fold((object) ["a" => 1, "c" => 3])->efToDictionary()
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function has()
    {
        AssertEqualsFluent::applyWith(
            // if no 0 - [true, false]
            false,
            ClassShooped::class,
            12.66
        )->unfoldUsing(
            ClassShooped::fold(true)->has(1)
        );

        AssertEqualsFluent::applyWith(
            true,
            ClassShooped::class,
            1.67
        )->unfoldUsing(
            ClassShooped::fold(3)->has(3)
        );

        AssertEqualsFluent::applyWith(
            false,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold(2.5)->has(2)
        );

        AssertEqualsFluent::applyWith(
            true,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold(2.5)->has(2.0)
        );

        AssertEqualsFluent::applyWith(
            true,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold([3, 1, 3])->has(3)
        );

        AssertEqualsFluent::applyWith(
            false,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold(["a" => 1, "b" => 3, "c" => 1])->has(5)
        );

        AssertEqualsFluent::applyWith(
            true,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold("Hi!")->has("!")
        );

        AssertEqualsFluent::applyWith(
            false,
            ClassShooped::class,
            0.54
        )->unfoldUsing(
            ClassShooped::fold((object) ["a" => 1, "c" => 3])->has(false)
        );

        // TODO: Objects
    }

    /**
     * @test
     * @group current
     */
    public function efHas()
    {
        AssertEqualsFluent::applyWith(
            // if no 0 - [true, false]
            false,
            "boolean",
            9.11
        )->unfoldUsing(
            ClassShooped::fold(true)->efHas(1)
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean",
            0.53
        )->unfoldUsing(
            ClassShooped::fold(3)->efHas(3)
        );

        AssertEqualsFluent::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            ClassShooped::fold(2.5)->efHas(2)
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            ClassShooped::fold(2.5)->efHas(2.0)
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            ClassShooped::fold([3, 1, 3])->efHas(3)
        );

        AssertEqualsFluent::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            ClassShooped::fold(["a" => 1, "b" => 3, "c" => 1])->efHas(5)
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            ClassShooped::fold("Hi!")->efHas("!")
        );

        AssertEqualsFluent::applyWith(
            false,
            "boolean",
            0.96
        )->unfoldUsing(
            ClassShooped::fold((object) ["a" => 1, "c" => 3])->efHas(false)
        );

        // TODO: Objects
    }
}
