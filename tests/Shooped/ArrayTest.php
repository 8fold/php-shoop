<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    Type,
    Shoop,
    ESArray,
    ESBool,
    ESDictionary,
    ESInt,
    ESJson,
    ESObject,
    ESString
};

/**
 * The `string()` method converts the 8fold type to an `ESString` type.
 *
 * Typpically uses PHP's `print_r()` after using `unfold()` on the value.
 *
 * This allows each Shoop type to be treated as a PHP `string`, which means `string()` is an alias for the PHP `__toString()` magic method.
 *
 * @declared Eightfold\Shoop\Interfaces\Shooped
 *
 * @defined Eightfold\Shoop\Traits\ShoopedImp
 *
 * @overridden Eightfold\Shoop\ESBool, Eightfold\Shoop\ESInt, Eightfold\Shoop\ESJson, Eightfold\Shoop\ESString
 *
 * @return Eightfold\Shoop\ESString
 */
class ArrayTest extends TestCase
{
    public function testESArray()
    {
        $expected = [];

        $actual = ESArray::fold([])->array();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESBool()
    {
        $expected = [true];

        $actual = ESBool::fold(true)->array();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESDictionary()
    {
        $expected = [];

        $actual = ESDictionary::fold([])->array();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESInt()
    {
        $expected = [1, 2, 3, 4, 5];

        $actual = ESInt::fold(5)->array();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * Uses `unfold()` on value to instantiate ESString.
     */
    public function testESJson()
    {
        $expected = ["test"];

        $actual = ESJson::fold('{"test":"test"}')->array();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESObject()
    {
        $expected = [];

        $actual = ESObject::fold(new \stdClass())->array();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESString()
    {
        $expected = ["h", "e", "l", "l", "o"];

        $actual = ESString::fold("hello")->array();
        $this->assertEquals($expected, $actual->unfold());
    }
}
