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
 * The `bool()` method converts the 8fold type to an `ESBool` type.
 *
 * Typically this means using PHP to cast the value after calling `unfold()`
 *
 * @declared Eightfold\Shoop\Interfaces\Shooped
 *
 * @defined Eightfold\Shoop\Traits\ShoopedImp
 *
 * @overridden Eightfold\Shoop\ESObject
 *
 * @return Eightfold\Shoop\ESBool
 */
class ToBoolTest extends TestCase
{
    public function testESArray()
    {
        $expected = true;

        $actual = ESArray::fold(['testing'])->bool();
        $this->assertEquals($expected, $actual->unfold());

        $expected = false;

        $actual = ESArray::fold([])->bool();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESBool()
    {
        $expected = true;

        $actual = ESBool::fold(true)->bool();
        $this->assertEquals($expected, $actual->unfold());

        $expected = false;

        $actual = ESBool::fold(false)->bool();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESDictionary()
    {
        $expected = false;

        $actual = ESDictionary::fold([])->bool();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESInt()
    {
        $expected = true;

        $actual = ESInt::fold(1)->bool();
        $this->assertEquals($expected, $actual->unfold());

        $expected = false;

        $actual = ESInt::fold(0)->bool();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * Converts to an array before checking if empty.
     *
     * @see Eightfold\Shoop\Test\ToArray
     */
    public function testESJson()
    {
        $expected = true;

        $actual = ESJson::fold('{"test":"test"}')->bool();
        $this->assertEquals($expected, $actual->unfold());

        $expected = false;

        $actual = ESJson::fold('{}')->bool();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * Converts to an array before checking if empty.
     *
     * @see Eightfold\Shoop\Test\ToArray
     */
    public function testESObject()
    {
        $expected = false;

        $actual = ESObject::fold(new \stdClass())->bool();
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
