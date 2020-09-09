<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Shooped;

trait Associable
{
    /**
     * @test
     */
    public function asDictionary()
    {
        AssertEquals::applyWith(
            // if no 0 - [true, false]
            ["false" => false, "true" => true],
            "array",
            6.98 // 2.47
        )->unfoldUsing(
            Shooped::fold(true)->asDictionary()
        );

        // TODO: Should arrays start at 1
        AssertEquals::applyWith(
            // ["i1" => 1, "i2" => 2, "i3" => 3]
            ["i0" => 0, "i1" => 1, "i2" => 2, "i3" => 3],
            "array",
            3.98
        )->unfoldUsing(
            Shooped::fold(3)->asDictionary()
        );

        // TODO: Should arrays start at 1
        AssertEquals::applyWith(
            // ["i1" => 1, "i2" => 2]
            ["i0" => 0, "i1" => 1, "i2" => 2],
            "array",
            0.72
        )->unfoldUsing(
            Shooped::fold(2.5)->asDictionary()
        );

        AssertEquals::applyWith(
            ["i0" => 3, "i1" => 1, "i2" => 3],
            "array"
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->asDictionary()
        );

        AssertEquals::applyWith(
            ["a" => 1, "b" => 3, "c" => 1],
            "array"
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->asDictionary()
        );

        AssertEquals::applyWith(
            ["content" => "Hi!"],
            "array"
        )->unfoldUsing(
            Shooped::fold("Hi!")->asDictionary()
        );

        AssertEquals::applyWith(
            ["a" => 1, "c" => 3],
            "array"
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
        AssertEquals::applyWith(
            // if no 0 - [true, false]
            ["false" => false, "true" => true],
            "array",
            2.05
        )->unfoldUsing(
            Shooped::fold(true)->efToDictionary()
        );

        // TODO: Should arrays start at 1
        AssertEquals::applyWith(
            // ["i1" => 1, "i2" => 2, "i3" => 3]
            ["i0" => 0, "i1" => 1, "i2" => 2, "i3" => 3],
            "array",
            2.35 // 0.92
        )->unfoldUsing(
            Shooped::fold(3)->efToDictionary()
        );

        // TODO: Should arrays start at 1
        AssertEquals::applyWith(
            // ["i1" => 1, "i2" => 2]
            ["i0" => 0, "i1" => 1, "i2" => 2],
            "array",
            0.48
        )->unfoldUsing(
            Shooped::fold(2.5)->efToDictionary()
        );

        AssertEquals::applyWith(
            ["i0" => 3, "i1" => 1, "i2" => 3],
            "array"
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->efToDictionary()
        );

        AssertEquals::applyWith(
            ["a" => 1, "b" => 3, "c" => 1],
            "array"
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->efToDictionary()
        );

        AssertEquals::applyWith(
            ["content" => "Hi!"],
            "array"
        )->unfoldUsing(
            Shooped::fold("Hi!")->efToDictionary()
        );

        AssertEquals::applyWith(
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
        AssertEquals::applyWith(
            // if no 0 - [true, false]
            false,
            "boolean",
            12.66,
            67
        )->unfoldUsing(
            Shooped::fold(true)->has(1)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            1.67
        )->unfoldUsing(
            Shooped::fold(3)->has(3)
        );

        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(2.5)->has(2)
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(2.5)->has(2.0)
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->has(3)
        );

        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->has(5)
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold("Hi!")->has("!")
        );

        AssertEquals::applyWith(
            false,
            "boolean",
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
        AssertEquals::applyWith(
            // if no 0 - [true, false]
            false,
            "boolean",
            9.11
        )->unfoldUsing(
            Shooped::fold(true)->efHas(1)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.53
        )->unfoldUsing(
            Shooped::fold(3)->efHas(3)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.36
        )->unfoldUsing(
            Shooped::fold(2.5)->efHas(2)
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(2.5)->efHas(2.0)
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->efHas(3)
        );

        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->efHas(5)
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold("Hi!")->efHas("!")
        );

        AssertEquals::applyWith(
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
        AssertEquals::applyWith(
            true,
            "boolean",
            3.38, // 3.35 // 3.03
            81 // 79 // 16 // 15
        )->unfoldUsing(
            Shooped::fold(true)->hasAt(1)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.92 // 0.9 // 0.59 // 0.52 // 0.51 // 0.5 // 0.48
        )->unfoldUsing(
            Shooped::fold(3)->hasAt(4)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            1.57 // 0.75 // 0.7 // 0.63
        )->unfoldUsing(
            Shooped::fold(2.5)->hasAt(2)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.69
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->hasAt(4)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.84 // 0.59 // 0.54 // 0.53 // 0.52 // 0.5 // 0.46 // 0.4
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->hasAt("c")
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.81 // 0.8 // 0.55
        )->unfoldUsing(
            Shooped::fold("Hi!")->hasAt(2)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.78 // 0.72 // 0.69 // 0.59 // 0.56 // 0.53
        )->unfoldUsing(
            Shooped::fold("Hi!")->hasAt("content")
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.61 // 0.51 // 0.5
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
        AssertEquals::applyWith(
            true,
            "boolean",
            16.54 // 11.44
        )->unfoldUsing(
            Shooped::fold(true)->offsetExists(1)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            1.46 // 1.03 // 0.9 // 0.82 // 0.68
        )->unfoldUsing(
            Shooped::fold(3)->offsetExists(3)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.66 // 0.61 // 0.59 // 0.51 // 0.4
        )->unfoldUsing(
            Shooped::fold(2.5)->offsetExists(3)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.62 // 0.59 // 0.54 // 0.51
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->offsetExists(2)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.63 // 0.52
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->offsetExists("d")
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.54 // 0.52 // 0.48
        )->unfoldUsing(
            Shooped::fold("Hi!")->offsetExists(4)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.79 // 0.78 // 0.72 // 0.67
        )->unfoldUsing(
            Shooped::fold("Hi!")->offsetExists(0)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            1.33 // 0.81 // 0.75 // 0.63 // 0.61
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
        AssertEquals::applyWith(
            true,
            "boolean",
            10.5,
            230
        )->unfoldUsing(
            Shooped::fold(true)->at(1)
        );

        AssertEquals::applyWith(
            3,
            "integer",
            0.51
        )->unfoldUsing(
            Shooped::fold(3)->at(3)
        );

        AssertEquals::applyWith(
            2.0,
            "double",
            0.35
        )->unfoldUsing(
            Shooped::fold(2.5)->at([2, 3])
        );

        AssertEquals::applyWith(
            [1.0, 2.0],
            "array",
            2.01 // 0.44 // 0.35 // 0.32
        )->unfoldUsing(
            Shooped::fold(2.5)->at([1, 2, 3])
        );

        AssertEquals::applyWith(
            1,
            "integer"
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->at(1)
        );

        AssertEquals::applyWith(
            3,
            "integer",
            2.6, // 2.3 // 2.17
            210
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->at("b")
        );

        AssertEquals::applyWith(
            "H",
            "string",
            0.57,
            19
        )->unfoldUsing(
            Shooped::fold("Hi!")->at(0)
        );

        AssertEquals::applyWith(
            "Hi!",
            "string",
            3.83,
            11
        )->unfoldUsing(
            Shooped::fold("Hi!")->at("content")
        );

        AssertEquals::applyWith(
            1,
            "integer",
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
        AssertEquals::applyWith(
            true,
            "boolean",
            3.51
        )->unfoldUsing(
            Shooped::fold(true)->offsetGet(1)
        );

        AssertEquals::applyWith(
            3,
            "integer",
            0.35 // 0.34 // 0.32
        )->unfoldUsing(
            Shooped::fold(3)->offsetGet(3)
        );

        AssertEquals::applyWith(
            2.0,
            "double",
            0.41 // 0.31
        )->unfoldUsing(
            Shooped::fold(2.5)->offsetGet([2, 3])
        );

        AssertEquals::applyWith(
            [1.0, 2.0],
            "array",
            0.64 // 0.51 // 0.36
        )->unfoldUsing(
            Shooped::fold(2.5)->offsetGet([1, 2, 3])
        );

        AssertEquals::applyWith(
            1,
            "integer"
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->offsetGet(1)
        );

        AssertEquals::applyWith(
            3,
            "integer"
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->offsetGet("b")
        );

        AssertEquals::applyWith(
            "H",
            "string",
            0.33 // 0.31
        )->unfoldUsing(
            Shooped::fold("Hi!")->offsetGet(0)
        );

        AssertEquals::applyWith(
            "Hi!",
            "string",
            0.31
        )->unfoldUsing(
            Shooped::fold("Hi!")->offsetGet("content")
        );

        AssertEquals::applyWith(
            1,
            "integer",
            3.66 // 0.33
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
        AssertEquals::applyWith(
            true,
            "boolean",
            4.58,
            103 // 39
        )->unfoldUsing(
            Shooped::fold(false)->plusAt(1)
        );

        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(true)->plusAt(-1)
        );

        AssertEquals::applyWith(
            6,
            "integer"
        )->unfoldUsing(
            Shooped::fold(3)->plusAt(3)
        );

        AssertEquals::applyWith(
            3.5,
            "double"
        )->unfoldUsing(
            Shooped::fold(2.5)->plusAt(1)
        );

        AssertEquals::applyWith(
            [3, 1, 3, 1],
            "array",
            9.52,
            78 // 14
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->plusAt(1)
        );

        AssertEquals::applyWith(
            [1, 1, 3],
            "array",
            3.42 // 3.26
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->plusAt(1, 0)
        );

        AssertEquals::applyWith(
            [1, 1, 3],
            "array",
            1.19
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->plusAt(1, 0, true)
        );

        AssertEquals::applyWith(
            ["a" => 1, "c" => 3, "b" => 2],
            "array",
            1.88
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "c" => 3])->plusAt(2, "b")
        );

        AssertEquals::applyWith(
            "Hi!",
            "string",
            1.14 // 1.12
        )->unfoldUsing(
            Shooped::fold("H!")->plusAt("Hi", 0)
        );

        AssertEquals::applyWith(
            "Ho!",
            "string",
            1.83 // 0.71 // 0.68 // 0.6
        )->unfoldUsing(
            Shooped::fold("Hi!")->plusAt("o", 1, true)
        );

        AssertEquals::applyWith(
            (object) ["a" => 2, "c" => 3],
            "object",
            0.71,
            12
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
        AssertEquals::applyWith(
            true,
            "boolean",
            3.46,
            77 // 13
        )->unfoldUsing(
            Shooped::fold(false)->minusAt(1)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.58 // 0.41 // 0.35 // 0.33
        )->unfoldUsing(
            Shooped::fold(true)->minusAt("true")
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.42 // 0.34 // 0.33
        )->unfoldUsing(
            Shooped::fold(false)->minusAt(0)
        );

        AssertEquals::applyWith(
            0,
            "integer",
            0.84, // 0.71 // 0.62
            88 // 24 // 19
        )->unfoldUsing(
            Shooped::fold(3)->minusAt(3)
        );

        AssertEquals::applyWith(
            1.5,
            "double"
        )->unfoldUsing(
            Shooped::fold(2.5)->minusAt(1)
        );

        AssertEquals::applyWith(
            [3, 3],
            "array"
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->minusAt(1)
        );

        AssertEquals::applyWith(
            ["a" => 1],
            "array"
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "c" => 3])->minusAt("c")
        );

        AssertEquals::applyWith(
            "H!",
            "string",
            0.53 // 0.5 // 0.41 // 0.4 // 0.37 // 0.31
        )->unfoldUsing(
            Shooped::fold("Hi!")->minusAt(1)
        );

        AssertEquals::applyWith(
            (object) ["c" => 3],
            "object",
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
