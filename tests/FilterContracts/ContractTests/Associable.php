<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Shooped;

trait Associable
{
    /**
     * @test
     * @version 1.0.0
     */
    public function asDictionary()
    {
        AssertEquals::applyWith(
            ["false" => false, "true" => true],
            "array",
            6.58,
            226
        )->unfoldUsing(
            Shooped::fold(true)->asDictionary()
        );

        AssertEquals::applyWith(
            ["0.0" => 3],
            "array",
            0.3, // 0.26, // 0.24,
            10
        )->unfoldUsing(
            Shooped::fold(3)->asDictionary()
        );

        AssertEquals::applyWith(
            ["0.0" => 2.5],
            "array",
            0.04, // 0.03,
            1
        )->unfoldUsing(
            Shooped::fold(2.5)->asDictionary()
        );

        AssertEquals::applyWith(
            ["0.0" => 3, "1.0" => 1, "2.0" => 3],
            "array",
            0.09, // 0.08, // 0.08,
            2
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->asDictionary()
        );

        AssertEquals::applyWith(
            ["a" => 1, "b" => 3, "c" => 1],
            "array",
            0.03,
            1
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->asDictionary()
        );

        AssertEquals::applyWith(
            ["content" => "Hi!"],
            "array",
            1.22,
            5
        )->unfoldUsing(
            Shooped::fold("Hi!")->asDictionary()
        );

        AssertEquals::applyWith(
            ["a" => 1, "c" => 3],
            "array",
            3.25,
            16
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->asDictionary()
        );

        // TODO: Objects
    }

    /**
     * @test
     * @version 1.0.0
     */
    public function efToDictionary()
    {
        AssertEquals::applyWith(
            ["false" => false, "true" => true],
            "array",
            3.1, // 2.97, // 2.86, // 2.85, // 2.69, // 2.52, // 2.5, // 2.39,
            226
        )->unfoldUsing(
            Shooped::fold(true)->efToDictionary()
        );

        // TODO: Should arrays start at 1
        AssertEquals::applyWith(
            ["0.0" => 3],
            "array",
            0.27, // 0.26, // 0.24,
            10
        )->unfoldUsing(
            Shooped::fold(3)->efToDictionary()
        );

        // TODO: Should arrays start at 1
        AssertEquals::applyWith(
            // ["i1" => 1, "i2" => 2]
            ["0.0" => 2.5],
            "array",
            0.03,
            1
        )->unfoldUsing(
            Shooped::fold(2.5)->efToDictionary()
        );

        AssertEquals::applyWith(
            ["0.0" => 3, "1.0" => 1, "2.0" => 3],
            "array",
            0.09, // 0.08,
            2
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->efToDictionary()
        );

        AssertEquals::applyWith(
            ["a" => 1, "b" => 3, "c" => 1],
            "array",
            0.03,
            1
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->efToDictionary()
        );

        AssertEquals::applyWith(
            ["content" => "Hi!"],
            "array",
            0.12, // 0.11, // 0.95,
            5
        )->unfoldUsing(
            Shooped::fold("Hi!")->efToDictionary()
        );

        AssertEquals::applyWith(
            ["a" => 1, "c" => 3],
            "array",
            0.41, // 0.35,
            16
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->efToDictionary()
        );

        // TODO: Objects
    }

    /**
     * @test
     * @version 1.0.0
     *
     * Strict type checking is used
     */
    public function has()
    {
        // AssertEquals::applyWith(
        //     // if no 0 - [true, false]
        //     false,
        //     "boolean",
        //     12.66,
        //     67
        // )->unfoldUsing(
        //     Shooped::fold(true)->has(1)
        // );

        // AssertEquals::applyWith(
        //     true,
        //     "boolean",
        //     1.67
        // )->unfoldUsing(
        //     Shooped::fold(3)->has(3)
        // );

        AssertEquals::applyWith(
            true,
            "boolean",
            5.68, // 2.67,
            228 // 227
        )->unfoldUsing(
            Shooped::fold(2.5)->has(2)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.06, // 0.03, // 0.02,
            1
        )->unfoldUsing(
            Shooped::fold(2.5)->has(3.0)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.13,
            2
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->has(3)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.02,
            1
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->has(5)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.12,
            4
        )->unfoldUsing(
            Shooped::fold("Hi!")->has("!")
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.59,
            33
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
        // AssertEquals::applyWith(
        //     // if no 0 - [true, false]
        //     false,
        //     "boolean",
        //     0.001,
        //     1
        // )->unfoldUsing(
        //     Shooped::fold(true)->efHas(1)
        // );

        // AssertEquals::applyWith(
        //     true,
        //     "boolean",
        //     0.53
        // )->unfoldUsing(
        //     Shooped::fold(3)->efHas(3)
        // );

        AssertEquals::applyWith(
            true,
            "boolean",
            2.97, // 2.73,
            228
        )->unfoldUsing(
            Shooped::fold(2.5)->efHas(2)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.03,
            1
        )->unfoldUsing(
            Shooped::fold(2.5)->efHas(3.0)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.09,
            1
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->efHas(3)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.04, // 0.02,
            1
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->efHas(5)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.15, // 0.1,
            4
        )->unfoldUsing(
            Shooped::fold("Hi!")->efHas("!")
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.55, // 0.46,
            33
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
        // AssertEquals::applyWith(
        //     true,
        //     "boolean",
        //     3.38, // 3.35 // 3.03
        //     81 // 79 // 16 // 15
        // )->unfoldUsing(
        //     Shooped::fold(true)->hasAt(1)
        // );

        // AssertEquals::applyWith(
        //     false,
        //     "boolean",
        //     1.5 // 1.16 // 0.92 // 0.9 // 0.59 // 0.52 // 0.51 // 0.5 // 0.48
        // )->unfoldUsing(
        //     Shooped::fold(3)->hasAt(4)
        // );

        AssertEquals::applyWith(
            true,
            "boolean",
            16.14,
            239 // 238
        )->unfoldUsing(
            Shooped::fold(2.5)->hasAt(2)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            1.82, // 0.79,
            16 // 6
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->hasAt(4)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.94, // 0.03,
            17
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->hasAt("c")
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.13, // 0.12, // 0.11,
            4
        )->unfoldUsing(
            Shooped::fold("Hi!")->hasAt(2)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.31, // 0.3,
            11
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
        // AssertEquals::applyWith(
        //     true,
        //     "boolean",
        //     0.001,
        //     1
        // )->unfoldUsing(
        //     Shooped::fold(true)->offsetExists(1)
        // );

        AssertEquals::applyWith(
            true,
            "boolean",
            12.57,
            239
        )->unfoldUsing(
            Shooped::fold(3)->offsetExists(3)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.03, // 0.02,
            1
        )->unfoldUsing(
            Shooped::fold(2.5)->offsetExists(3)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            1.58,
            16
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->offsetExists(2)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.95,
            17
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->offsetExists("d")
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.13,
            4
        )->unfoldUsing(
            Shooped::fold("Hi!")->offsetExists(4)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.03,
            1
        )->unfoldUsing(
            Shooped::fold("Hi!")->offsetExists(0)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            1.61,
            11
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
        // AssertEquals::applyWith(
        //     true,
        //     "boolean",
        //     10.5,
        //     230
        // )->unfoldUsing(
        //     Shooped::fold(true)->at(1)
        // );

        // AssertEquals::applyWith(
        //     3,
        //     "integer",
        //     0.61 // 0.6 // 0.51
        // )->unfoldUsing(
        //     Shooped::fold(3)->at(3)
        // );

        // AssertEquals::applyWith(
        //     2.0,
        //     "double",
        //     0.38 // 0.35
        // )->unfoldUsing(
        //     Shooped::fold(2.5)->at([2, 3])
        // );

        // AssertEquals::applyWith(
        //     [1.0, 2.0],
        //     "array",
        //     2.01 // 0.44 // 0.35 // 0.32
        // )->unfoldUsing(
        //     Shooped::fold(2.5)->at([1, 2, 3])
        // );

        AssertEquals::applyWith(
            1,
            "integer",
            5.23, // 3.42, // 2.95, // 2.93, // 2.76, // 2.53,
            223
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->at(1)
        );

        AssertEquals::applyWith(
            3,
            "integer",
            0.03,
            1
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->at("b")
        );

        AssertEquals::applyWith(
            "H",
            "string",
            0.2,
            6
        )->unfoldUsing(
            Shooped::fold("Hi!")->at(0)
        );

        AssertEquals::applyWith(
            1,
            "integer",
            2.99,
            257
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
        // AssertEquals::applyWith(
        //     true,
        //     "boolean",
        //     3.51
        // )->unfoldUsing(
        //     Shooped::fold(true)->offsetGet(1)
        // );

        // AssertEquals::applyWith(
        //     3,
        //     "integer",
        //     0.38 // 0.35 // 0.34 // 0.32
        // )->unfoldUsing(
        //     Shooped::fold(3)->offsetGet(3)
        // );

        // AssertEquals::applyWith(
        //     2.0,
        //     "double",
        //     0.41 // 0.31
        // )->unfoldUsing(
        //     Shooped::fold(2.5)->offsetGet([2, 3])
        // );

        // AssertEquals::applyWith(
        //     [1.0, 2.0],
        //     "array",
        //     0.64 // 0.51 // 0.36
        // )->unfoldUsing(
        //     Shooped::fold(2.5)->offsetGet([1, 2, 3])
        // );

        AssertEquals::applyWith(
            1,
            "integer",
            2.91,
            223
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->offsetGet(1)
        );

        AssertEquals::applyWith(
            3,
            "integer",
            0.02,
            1
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->offsetGet("b")
        );

        AssertEquals::applyWith(
            "H",
            "string",
            0.16,
            6
        )->unfoldUsing(
            Shooped::fold("Hi!")->offsetGet(0)
        );

        // AssertEquals::applyWith(
        //     "Hi!",
        //     "string",
        //     0.001,
        //     1
        // )->unfoldUsing(
        //     Shooped::fold("Hi!")->offsetGet("content")
        // );

        AssertEquals::applyWith(
            1,
            "integer",
            0.46, // 0.39,
            29
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->offsetGet("a")
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function insertAt()
    {
        // AssertEquals::applyWith(
        //     true,
        //     "boolean",
        //     4.58,
        //     103 // 39
        // )->unfoldUsing(
        //     Shooped::fold(false)->insertAt(1)
        // );

        // AssertEquals::applyWith(
        //     false,
        //     "boolean"
        // )->unfoldUsing(
        //     Shooped::fold(true)->insertAt(-1)
        // );

        // AssertEquals::applyWith(
        //     6,
        //     "integer"
        // )->unfoldUsing(
        //     Shooped::fold(3)->insertAt(3)
        // );

        // AssertEquals::applyWith(
        //     3.5,
        //     "double"
        // )->unfoldUsing(
        //     Shooped::fold(2.5)->insertAt(1)
        // );

        AssertEquals::applyWith(
            [1, 3, 1, 3],
            "array",
            3.39, // 3.24, // 3.07, // 2.88, // 2.79,
            254 // 253
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->insertAt(1, -1)
        );

        // AssertEquals::applyWith(
        //     [1, 1, 3],
        //     "array",
        //     3.42 // 3.26
        // )->unfoldUsing(
        //     Shooped::fold([3, 1, 3])->insertAt(1, 0)
        // );

        // AssertEquals::applyWith(
        //     [1, 1, 3],
        //     "array",
        //     1.19
        // )->unfoldUsing(
        //     Shooped::fold([3, 1, 3])->insertAt(1, 0)
        // );

        // AssertEquals::applyWith(
        //     ["a" => 1, "c" => 3, "b" => 2],
        //     "array",
        //     1.88
        // )->unfoldUsing(
        //     Shooped::fold(["a" => 1, "c" => 3])->insertAt(2, "b")
        // );

        AssertEquals::applyWith(
            "Hi!",
            "string",
            0.39, // 0.31,
            21
        )->unfoldUsing(
            Shooped::fold("!")->insertAt("Hi", -1)
        );

        AssertEquals::applyWith(
            "Ho!",
            "string",
            0.04, // 0.03,
            1
        )->unfoldUsing(
            Shooped::fold("Hi!")->insertAt("o", 1)
        );

        AssertEquals::applyWith(
            (object) ["a" => 2, "c" => 3],
            "object",
            1.24,
            29
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->insertAt(2, "a")
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
    public function removeAt()
    {
        // AssertEquals::applyWith(
        //     true,
        //     "boolean",
        //     0.001,
        //     1
        // )->unfoldUsing(
        //     Shooped::fold(false)->removeAt(1)
        // );

        // AssertEquals::applyWith(
        //     false,
        //     "boolean",
        //     0.001,
        //     1
        // )->unfoldUsing(
        //     Shooped::fold(true)->removeAt("true")
        // );

        // AssertEquals::applyWith(
        //     false,
        //     "boolean",
        //     0.001,
        //     1
        // )->unfoldUsing(
        //     Shooped::fold(false)->removeAt(0)
        // );

        // AssertEquals::applyWith(
        //     0,
        //     "integer",
        //     0.001,
        //     1
        // )->unfoldUsing(
        //     Shooped::fold(3)->removeAt(3)
        // );

        // AssertEquals::applyWith(
        //     1.5,
        //     "double",
        //     0.001,
        //     1
        // )->unfoldUsing(
        //     Shooped::fold(2.5)->removeAt(1)
        // );

        AssertEquals::applyWith(
            [3, 3],
            "array",
            4.41, // 3.45, // 3.09, // 2.94, // 2.76, // 2.75, // 2.65, // 2.43,
            257 // 254 // 253 // 252
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->removeAt(1)
        );

        AssertEquals::applyWith(
            ["a" => 1],
            "array",
            0.03,
            1
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "c" => 3])->removeAt("c")
        );

        AssertEquals::applyWith(
            "H!",
            "string",
            0.13, // 0.11,
            4
        )->unfoldUsing(
            Shooped::fold("Hi!")->removeAt(1)
        );

        AssertEquals::applyWith(
            (object) ["c" => 3],
            "object",
            0.71,
            46
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->removeAt("a")
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
     * @group current
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
