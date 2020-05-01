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
class DictionaryTest extends TestCase
{
    public function testESArray()
    {
        $expected = ["i0" => "hi"];

        $actual = ESArray::fold([0 => "hi"])->dictionary();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESBool()
    {
        $expected = ["true" => true, "false" => false];

        $actual = ESBool::fold(true)->dictionary();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESDictionary()
    {
        $expected = ["hello" => "world"];

        $actual = ESDictionary::fold($expected)->dictionary();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESInt()
    {
        $expected = ["i0" => 0, "i1" => 1, "i2" => 2, "i3" => 3, "i4" => 4, "i5" => 5];

        $actual = ESInt::fold(5)->dictionary();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESJson()
    {
        $expected = ["test" => true];

        $actual = ESJson::fold('{"test":true}')->dictionary();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESObject()
    {
        $expected = ["test" => true];

        $object = new \stdClass();
        $object->test = true;

        $actual = ESObject::fold($object)->dictionary();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESString()
    {
        $expected = ["i0" => "h", "i1" => "e", "i2" => "l", "i3" => "l", "i4" => "o"];

        $actual = ESString::fold("hello")->dictionary();
        $this->assertEquals($expected, $actual->unfold());
    }
}
