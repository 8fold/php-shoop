<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Shoop\Tests\TestClasses\AssertEqualsFluent;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Shooped;

trait Associable
{
    /**
     * @test
     */
    public function asDictionary()
    {
        AssertEqualsFluent::applyWith(
            // if no 0 - [true, false]
            ["false" => false, "true" => true],
            Shooped::class,
            6.98 // 2.47
        )->unfoldUsing(
            Shooped::fold(true)->asDictionary()
        );

        // TODO: Should arrays start at 1
        AssertEqualsFluent::applyWith(
            // ["i1" => 1, "i2" => 2, "i3" => 3]
            ["i0" => 0, "i1" => 1, "i2" => 2, "i3" => 3],
            Shooped::class,
            3.98
        )->unfoldUsing(
            Shooped::fold(3)->asDictionary()
        );

        // TODO: Should arrays start at 1
        AssertEqualsFluent::applyWith(
            // ["i1" => 1, "i2" => 2]
            ["i0" => 0, "i1" => 1, "i2" => 2],
            Shooped::class,
            0.72
        )->unfoldUsing(
            Shooped::fold(2.5)->asDictionary()
        );

        AssertEqualsFluent::applyWith(
            ["i0" => 3, "i1" => 1, "i2" => 3],
            Shooped::class
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->asDictionary()
        );

        AssertEqualsFluent::applyWith(
            ["a" => 1, "b" => 3, "c" => 1],
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->asDictionary()
        );

        AssertEqualsFluent::applyWith(
            ["content" => "Hi!"],
            Shooped::class
        )->unfoldUsing(
            Shooped::fold("Hi!")->asDictionary()
        );

        AssertEqualsFluent::applyWith(
            ["a" => 1, "c" => 3],
            Shooped::class
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->asDictionary()
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
            Shooped::fold(true)->efToDictionary()
        );

        // TODO: Should arrays start at 1
        AssertEqualsFluent::applyWith(
            // ["i1" => 1, "i2" => 2, "i3" => 3]
            ["i0" => 0, "i1" => 1, "i2" => 2, "i3" => 3],
            "array",
            2.35 // 0.92
        )->unfoldUsing(
            Shooped::fold(3)->efToDictionary()
        );

        // TODO: Should arrays start at 1
        AssertEqualsFluent::applyWith(
            // ["i1" => 1, "i2" => 2]
            ["i0" => 0, "i1" => 1, "i2" => 2],
            "array"
        )->unfoldUsing(
            Shooped::fold(2.5)->efToDictionary()
        );

        AssertEqualsFluent::applyWith(
            ["i0" => 3, "i1" => 1, "i2" => 3],
            "array"
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->efToDictionary()
        );

        AssertEqualsFluent::applyWith(
            ["a" => 1, "b" => 3, "c" => 1],
            "array"
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->efToDictionary()
        );

        AssertEqualsFluent::applyWith(
            ["content" => "Hi!"],
            "array"
        )->unfoldUsing(
            Shooped::fold("Hi!")->efToDictionary()
        );

        AssertEqualsFluent::applyWith(
            ["a" => 1, "c" => 3],
            "array"
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->efToDictionary()
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
            Shooped::class,
            12.66
        )->unfoldUsing(
            Shooped::fold(true)->has(1)
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class,
            1.67
        )->unfoldUsing(
            Shooped::fold(3)->has(3)
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(2.5)->has(2)
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(2.5)->has(2.0)
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->has(3)
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->has(5)
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold("Hi!")->has("!")
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class,
            0.54
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->has(false)
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
            Shooped::fold(true)->efHas(1)
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean",
            0.53
        )->unfoldUsing(
            Shooped::fold(3)->efHas(3)
        );

        AssertEqualsFluent::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(2.5)->efHas(2)
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(2.5)->efHas(2.0)
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->efHas(3)
        );

        AssertEqualsFluent::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->efHas(5)
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold("Hi!")->efHas("!")
        );

        AssertEqualsFluent::applyWith(
            false,
            "boolean",
            0.96
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->efHas(false)
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
            Shooped::class,
            3.38 // 3.35 // 3.03
        )->unfoldUsing(
            Shooped::fold(true)->hasAt(1)
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class,
            0.9 // 0.59 // 0.52 // 0.51 // 0.5 // 0.48
        )->unfoldUsing(
            Shooped::fold(3)->hasAt(4)
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class,
            1.57 // 0.75 // 0.7 // 0.63
        )->unfoldUsing(
            Shooped::fold(2.5)->hasAt(2)
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class,
            0.69
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->hasAt(4)
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class,
            0.53 // 0.52 // 0.5 // 0.46 // 0.4
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->hasAt("c")
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class,
            0.8 // 0.55
        )->unfoldUsing(
            Shooped::fold("Hi!")->hasAt(2)
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class,
            0.69 // 0.59 // 0.56 // 0.53
        )->unfoldUsing(
            Shooped::fold("Hi!")->hasAt("content")
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->hasAt("b")
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
            Shooped::fold(true)->offsetExists(1)
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean",
            1.03 // 0.9 // 0.82 // 0.68
        )->unfoldUsing(
            Shooped::fold(3)->offsetExists(3)
        );

        AssertEqualsFluent::applyWith(
            false,
            "boolean",
            0.61 // 0.59 // 0.51 // 0.4
        )->unfoldUsing(
            Shooped::fold(2.5)->offsetExists(3)
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean",
            0.59 // 0.54 // 0.51
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->offsetExists(2)
        );

        AssertEqualsFluent::applyWith(
            false,
            "boolean",
            0.63 // 0.52
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->offsetExists("d")
        );

        AssertEqualsFluent::applyWith(
            false,
            "boolean",
            0.54 // 0.52 // 0.48
        )->unfoldUsing(
            Shooped::fold("Hi!")->offsetExists(4)
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean",
            0.78 // 0.72 // 0.67
        )->unfoldUsing(
            Shooped::fold("Hi!")->offsetExists(0)
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean",
            0.75 // 0.63 // 0.61
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->offsetExists("a")
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
            Shooped::class,
            10.5
        )->unfoldUsing(
            Shooped::fold(true)->at(1)
        );

        AssertEqualsFluent::applyWith(
            3,
            Shooped::class,
            0.51
        )->unfoldUsing(
            Shooped::fold(3)->at(3)
        );

        AssertEqualsFluent::applyWith(
            2.0,
            Shooped::class,
            0.35
        )->unfoldUsing(
            Shooped::fold(2.5)->at([2, 3])
        );

        AssertEqualsFluent::applyWith(
            [1.0, 2.0],
            Shooped::class,
            0.44 // 0.35 // 0.32
        )->unfoldUsing(
            Shooped::fold(2.5)->at([1, 2, 3])
        );

        AssertEqualsFluent::applyWith(
            1,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->at(1)
        );

        AssertEqualsFluent::applyWith(
            3,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->at("b")
        );

        AssertEqualsFluent::applyWith(
            "H",
            Shooped::class,
            0.57
        )->unfoldUsing(
            Shooped::fold("Hi!")->at(0)
        );

        AssertEqualsFluent::applyWith(
            "Hi!",
            Shooped::class,
            3.83
        )->unfoldUsing(
            Shooped::fold("Hi!")->at("content")
        );

        AssertEqualsFluent::applyWith(
            1,
            Shooped::class,
            0.41 // 0.37
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->at("a")
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
            Shooped::fold(true)->offsetGet(1)
        );

        AssertEqualsFluent::applyWith(
            3,
            "integer",
            0.35 // 0.34 // 0.32
        )->unfoldUsing(
            Shooped::fold(3)->offsetGet(3)
        );

        AssertEqualsFluent::applyWith(
            2.0,
            "double",
            0.31
        )->unfoldUsing(
            Shooped::fold(2.5)->offsetGet([2, 3])
        );

        AssertEqualsFluent::applyWith(
            [1.0, 2.0],
            "array",
            0.51 // 0.36
        )->unfoldUsing(
            Shooped::fold(2.5)->offsetGet([1, 2, 3])
        );

        AssertEqualsFluent::applyWith(
            1,
            "integer"
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->offsetGet(1)
        );

        AssertEqualsFluent::applyWith(
            3,
            "integer"
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->offsetGet("b")
        );

        AssertEqualsFluent::applyWith(
            "H",
            "string",
            0.31
        )->unfoldUsing(
            Shooped::fold("Hi!")->offsetGet(0)
        );

        AssertEqualsFluent::applyWith(
            "Hi!",
            "string"
        )->unfoldUsing(
            Shooped::fold("Hi!")->offsetGet("content")
        );

        AssertEqualsFluent::applyWith(
            1,
            "integer"
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->offsetGet("a")
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
            Shooped::class,
            4.58
        )->unfoldUsing(
            Shooped::fold(false)->plusAt(1)
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(true)->plusAt(-1)
        );

        AssertEqualsFluent::applyWith(
            6,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(3)->plusAt(3)
        );

        AssertEqualsFluent::applyWith(
            3.5,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(2.5)->plusAt(1)
        );

        AssertEqualsFluent::applyWith(
            [3, 1, 3, 1],
            Shooped::class,
            9.52
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->plusAt(1)
        );

        AssertEqualsFluent::applyWith(
            [3, 1, 1, 3],
            Shooped::class,
            3.26
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->plusAt(1, 0)
        );

        AssertEqualsFluent::applyWith(
            [1, 1, 3],
            Shooped::class,
            1.19
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->plusAt(1, 0, true)
        );

        AssertEqualsFluent::applyWith(
            ["a" => 1, "c" => 3, "b" => 2],
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "c" => 3])->plusAt(2, "b")
        );

        AssertEqualsFluent::applyWith(
            "Hi!",
            Shooped::class,
            1.14 // 1.12
        )->unfoldUsing(
            Shooped::fold("H!")->plusAt("i", 0)
        );

        AssertEqualsFluent::applyWith(
            "Ho!",
            Shooped::class,
            0.68 // 0.6
        )->unfoldUsing(
            Shooped::fold("Hi!")->plusAt("o", 1, true)
        );

        AssertEqualsFluent::applyWith(
            (object) ["a" => 2, "c" => 3],
            Shooped::class,
            0.71
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->plusAt(2, "a", true)
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

    /**
     * @test
     */
    public function minusAt()
    {
        AssertEqualsFluent::applyWith(
            true,
            Shooped::class,
            3.46
        )->unfoldUsing(
            Shooped::fold(false)->minusAt(1)
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class,
            0.41 // 0.35 // 0.33
        )->unfoldUsing(
            Shooped::fold(true)->minusAt("true")
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class,
            0.34 // 0.33
        )->unfoldUsing(
            Shooped::fold(false)->minusAt(0)
        );

        AssertEqualsFluent::applyWith(
            0,
            Shooped::class,
            0.84 // 0.71 // 0.62
        )->unfoldUsing(
            Shooped::fold(3)->minusAt(3)
        );

        AssertEqualsFluent::applyWith(
            1.5,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(2.5)->minusAt(1)
        );

        AssertEqualsFluent::applyWith(
            [3, 3],
            Shooped::class
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->minusAt(1)
        );

        AssertEqualsFluent::applyWith(
            ["a" => 1],
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "c" => 3])->minusAt("c")
        );

        AssertEqualsFluent::applyWith(
            "H!",
            Shooped::class,
            0.53 // 0.5 // 0.41 // 0.4 // 0.37 // 0.31
        )->unfoldUsing(
            Shooped::fold("Hi!")->minusAt(1)
        );

        AssertEqualsFluent::applyWith(
            (object) ["c" => 3],
            Shooped::class,
            1.11
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->minusAt("a")
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function offsetUnset()
    {
        // Returns void, uses PlusAt - TODO: maybe use different testing method
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function php_iterator()
    {
        $expectedKeys   = ["false", "true"];
        $expectedValues = [false, true];
        $actualKeys   = [];
        $actualValues = [];
        foreach (Shoop::this(true) as $key => $value) {
            $actualKeys[]   = $key;
            $actualValues[] = $value;
        }
        $this->assertEquals($expectedKeys, $actualKeys);
        $this->assertEquals($expectedValues, $actualValues);

        $expectedKeys   = [0, 1, 2];
        $expectedValues = [0, 1, 2];
        $actualKeys   = [];
        $actualValues = [];
        foreach (Shoop::this(2) as $key => $value) {
            $actualKeys[]   = $key;
            $actualValues[] = $value;
        }
        $this->assertEquals($expectedKeys, $actualKeys);
        $this->assertEquals($expectedValues, $actualValues);

        $expectedKeys   = ["a", "b"];
        $expectedValues = [1, 2];
        $actualKeys   = [];
        $actualValues = [];
        foreach (Shoop::this(["a" => 1, "b" => 2]) as $key => $value) {
            $actualKeys[]   = $key;
            $actualValues[] = $value;
        }
        $this->assertEquals($expectedKeys, $actualKeys);
        $this->assertEquals($expectedValues, $actualValues);

        $expectedKeys   = [0, 1, 2, 3, 4, 5];
        $expectedValues = ["8", "f", "o", "l", "d", "!"];
        $actualKeys   = [];
        $actualValues = [];
        foreach (Shoop::this("8fold!") as $key => $value) {
            $actualKeys[]   = $key;
            $actualValues[] = $value;
        }
        $this->assertEquals($expectedKeys, $actualKeys);
        $this->assertEquals($expectedValues, $actualValues);

        $expectedKeys   = ["a", "c"];
        $expectedValues = [1, 3];
        $actualKeys   = [];
        $actualValues = [];
        foreach (Shoop::this((object) ["a" => 1, "c" => 3]) as $key => $value) {
            $actualKeys[]   = $key;
            $actualValues[] = $value;
        }
        $this->assertEquals($expectedKeys, $actualKeys);
        $this->assertEquals($expectedValues, $actualValues);

        // TODO: Objects
    }
}
