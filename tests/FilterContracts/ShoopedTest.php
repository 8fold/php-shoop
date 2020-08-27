<?php

namespace Eightfold\Shoop\Tests\FilterContracts;

use Eightfold\Shoop\Tests\FilterContracts\FilterContractsTestCase;
use Eightfold\Shoop\Tests\AssertEqualsFluent;

use Eightfold\Shoop\Tests\FilterContracts\ContractTests\Foldable;

use Eightfold\Shoop\Tests\FilterContracts\ContractTests\Arrayable;

use Eightfold\Shoop\Tests\FilterContracts\ContractTests\Addable;
use Eightfold\Shoop\Tests\FilterContracts\ContractTests\Subtractable;

use Eightfold\Shoop\Tests\FilterContracts\ClassShooped;

/**
 * @group Shooped
 */
class ShoopedTest extends FilterContractsTestCase
{
    use Foldable, Arrayable, Addable, Subtractable;

    static public function sutClassName(): string
    {
        return ClassShooped::class;
    }

// - Arrayable

    /**
     * @test
     */
    public function asDictionary()
    {
        AssertEqualsFluent::applyWith(
            // if no 0 - [true, false]
            ["false" => false, "true" => true],
            ClassShooped::class,
            6.98 // 2.47
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
            ClassShooped::class,
            0.72
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
            2.35 // 0.92
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

    /**
     * @test
     */
    public function hasAt()
    {
        AssertEqualsFluent::applyWith(
            true,
            ClassShooped::class,
            3.35 // 3.03
        )->unfoldUsing(
            ClassShooped::fold(true)->hasAt(1)
        );

        AssertEqualsFluent::applyWith(
            false,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold(3)->hasAt(4)
        );

        AssertEqualsFluent::applyWith(
            true,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold(2.5)->hasAt(2)
        );

        AssertEqualsFluent::applyWith(
            false,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold([3, 1, 3])->hasAt(4)
        );

        AssertEqualsFluent::applyWith(
            true,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold(["a" => 1, "b" => 3, "c" => 1])->hasAt("c")
        );

        AssertEqualsFluent::applyWith(
            true,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold("Hi!")->hasAt(2)
        );

        AssertEqualsFluent::applyWith(
            true,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold("Hi!")->hasAt("content")
        );

        AssertEqualsFluent::applyWith(
            false,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold((object) ["a" => 1, "c" => 3])->hasAt("b")
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function offsetExists()
    {
        AssertEqualsFluent::applyWith(
            true,
            "boolean",
            16.54 // 11.44
        )->unfoldUsing(
            ClassShooped::fold(true)->offsetExists(1)
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            ClassShooped::fold(3)->offsetExists(3)
        );

        AssertEqualsFluent::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            ClassShooped::fold(2.5)->offsetExists(3)
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            ClassShooped::fold([3, 1, 3])->offsetExists(2)
        );

        AssertEqualsFluent::applyWith(
            false,
            "boolean",
            0.63 // 0.52
        )->unfoldUsing(
            ClassShooped::fold(["a" => 1, "b" => 3, "c" => 1])->offsetExists("d")
        );

        AssertEqualsFluent::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            ClassShooped::fold("Hi!")->offsetExists(4)
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            ClassShooped::fold("Hi!")->offsetExists(0)
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            ClassShooped::fold((object) ["a" => 1, "c" => 3])->offsetExists("a")
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function _at()
    {
        AssertEqualsFluent::applyWith(
            true,
            ClassShooped::class,
            10.5
        )->unfoldUsing(
            ClassShooped::fold(true)->at(1)
        );

        AssertEqualsFluent::applyWith(
            3,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold(3)->at(3)
        );

        AssertEqualsFluent::applyWith(
            2.0,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold(2.5)->at([2, 3])
        );

        AssertEqualsFluent::applyWith(
            [1.0, 2.0],
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold(2.5)->at([1, 2, 3])
        );

        AssertEqualsFluent::applyWith(
            1,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold([3, 1, 3])->at(1)
        );

        AssertEqualsFluent::applyWith(
            3,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold(["a" => 1, "b" => 3, "c" => 1])->at("b")
        );

        AssertEqualsFluent::applyWith(
            "H",
            ClassShooped::class,
            0.57
        )->unfoldUsing(
            ClassShooped::fold("Hi!")->at(0)
        );

        AssertEqualsFluent::applyWith(
            "Hi!",
            ClassShooped::class,
            3.83
        )->unfoldUsing(
            ClassShooped::fold("Hi!")->at("content")
        );

        AssertEqualsFluent::applyWith(
            1,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold((object) ["a" => 1, "c" => 3])->at("a")
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function offsetGet()
    {
        AssertEqualsFluent::applyWith(
            true,
            "boolean",
            3.51
        )->unfoldUsing(
            ClassShooped::fold(true)->offsetGet(1)
        );

        AssertEqualsFluent::applyWith(
            3,
            "integer"
        )->unfoldUsing(
            ClassShooped::fold(3)->offsetGet(3)
        );

        AssertEqualsFluent::applyWith(
            2.0,
            "double"
        )->unfoldUsing(
            ClassShooped::fold(2.5)->offsetGet([2, 3])
        );

        AssertEqualsFluent::applyWith(
            [1.0, 2.0],
            "array"
        )->unfoldUsing(
            ClassShooped::fold(2.5)->offsetGet([1, 2, 3])
        );

        AssertEqualsFluent::applyWith(
            1,
            "integer"
        )->unfoldUsing(
            ClassShooped::fold([3, 1, 3])->offsetGet(1)
        );

        AssertEqualsFluent::applyWith(
            3,
            "integer"
        )->unfoldUsing(
            ClassShooped::fold(["a" => 1, "b" => 3, "c" => 1])->offsetGet("b")
        );

        AssertEqualsFluent::applyWith(
            "H",
            "string"
        )->unfoldUsing(
            ClassShooped::fold("Hi!")->offsetGet(0)
        );

        AssertEqualsFluent::applyWith(
            "Hi!",
            "string"
        )->unfoldUsing(
            ClassShooped::fold("Hi!")->offsetGet("content")
        );

        AssertEqualsFluent::applyWith(
            1,
            "integer"
        )->unfoldUsing(
            ClassShooped::fold((object) ["a" => 1, "c" => 3])->offsetGet("a")
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function plusAt()
    {
        AssertEqualsFluent::applyWith(
            true,
            ClassShooped::class,
            4.58
        )->unfoldUsing(
            ClassShooped::fold(false)->plusAt(1)
        );

        AssertEqualsFluent::applyWith(
            false,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold(true)->plusAt(-1)
        );

        AssertEqualsFluent::applyWith(
            6,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold(3)->plusAt(3)
        );

        AssertEqualsFluent::applyWith(
            3.5,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold(2.5)->plusAt(1)
        );

        AssertEqualsFluent::applyWith(
            [3, 1, 3, 1],
            ClassShooped::class,
            9.52
        )->unfoldUsing(
            ClassShooped::fold([3, 1, 3])->plusAt(1)
        );

        AssertEqualsFluent::applyWith(
            [3, 1, 1, 3],
            ClassShooped::class,
            3.26
        )->unfoldUsing(
            ClassShooped::fold([3, 1, 3])->plusAt(1, 0)
        );

        AssertEqualsFluent::applyWith(
            [1, 1, 3],
            ClassShooped::class,
            1.19
        )->unfoldUsing(
            ClassShooped::fold([3, 1, 3])->plusAt(1, 0, true)
        );

        AssertEqualsFluent::applyWith(
            ["a" => 1, "c" => 3, "b" => 2],
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold(["a" => 1, "c" => 3])->plusAt(2, "b")
        );

        AssertEqualsFluent::applyWith(
            "Hi!",
            ClassShooped::class,
            1.12
        )->unfoldUsing(
            ClassShooped::fold("H!")->plusAt("i", 0)
        );

        AssertEqualsFluent::applyWith(
            "Ho!",
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold("Hi!")->plusAt("o", 1, true)
        );

        AssertEqualsFluent::applyWith(
            (object) ["a" => 2, "c" => 3],
            ClassShooped::class,
            0.4
        )->unfoldUsing(
            ClassShooped::fold((object) ["a" => 1, "c" => 3])->plusAt(2, "a", true)
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function offsetSet()
    {
        // Returns void, uses PlusAt - TODO: maybe use different testing method
        $this->assertTrue(true);
    }
}
