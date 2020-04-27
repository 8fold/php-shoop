<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    Type,
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
class ToStringTest extends TestCase
{
    public function testESArray()
    {
        $expected = "Array()";

        $actual = ESArray::fold([])->string();
        $this->assertEquals($expected, $actual->unfold());

        $expected = "Array([0] => testing)";

        $actual = ESArray::fold(['testing'])->string();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * Returns the plain text equivalent of the value. `true` is "true", `false` is "false".
     */
    public function testESBool()
    {
        $expected = "true";

        $actual = ESBool::fold(true)->string();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESDictionary()
    {
        $expected = "Array()";

        $actual = ESDictionary::fold([])->string();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * Uses PHP cast to `string`
     */
    public function testESInt()
    {
        $expected = "1";

        $actual = ESInt::fold(1)->string();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * Uses `unfold()` on value to instantiate ESString.
     */
    public function testESJson()
    {
        $expected = '{"test":"test"}';

        $actual = ESJson::fold($expected)->string();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESObject()
    {
        $expected = "stdClass Object()";

        $actual = ESObject::fold(new \stdClass())->string();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * Uses `unfold()` of value to instantiate new instance
     */
    public function testESString()
    {
        $expected = "hello";

        $actual = ESString::fold("hello")->string();
        $this->assertEquals($expected, $actual->unfold());
    }
}
