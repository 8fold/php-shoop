<?php

namespace Eightfold\Shoop\Tests;

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
 * The `int()` method converts the 8fold type to an `ESInt` type.
 *
 * Typically this means couting the number of values after calling `array()`.
 *
 * @see array() Eightfold\Shoop\Tests\ToArrayTest
 *
 * @declared Eightfold\Shoop\Interfaces\Shooped
 *
 * @defined Eightfold\Shoop\Traits\ShoopedImp
 *
 * @overridden Eightfold\Shoop\ESBool, Eightfold\Shoop\ESString
 *
 * @return Eightfold\Shoop\ESInt
 */
class ToIntTest extends TestCase
{
    public function testESArray()
    {
        $expected = 1;

        $actual = ESArray::fold(['testing'])->int();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * If initial was `true` returns 1, if `false` returns 0.
     */
    public function testESBool()
    {
        $expected = 1;

        $actual = ESBool::fold(true)->int();
        $this->assertEquals($expected, $actual->unfold());

        $expected = 0;

        $actual = ESBool::fold(false)->int();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESDictionary()
    {
        $expected = 0;

        $actual = ESDictionary::fold([])->int();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESInt()
    {
        $expected = 1;

        $actual = ESInt::fold(1)->int();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESJson()
    {
        $expected = 1;

        $actual = ESJson::fold('{"test":"test"}')->int();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESObject()
    {
        $expected = 0;

        $actual = ESObject::fold(new \stdClass())->int();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * Uses PHP `intval()` to parse the string and return the value.
     */
    public function testESString()
    {
        $expected = 0;

        $actual = ESString::fold("0")->int();
        $this->assertEquals($expected, $actual->unfold());

        $expected = 0;

        $actual = ESString::fold("hello")->int();
        $this->assertEquals($expected, $actual->unfold());
    }
}
