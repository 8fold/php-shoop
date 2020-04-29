<?php

namespace Eightfold\Shoop\Tests\MathOperations;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    Type,
    Shoop,
    ESArray,
    ESBool,
    ESInt,
    ESString,
    ESObject,
    ESJson,
    ESDictionary
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
class MinusTest extends TestCase
{
    public function testESArray()
    {
        $expected = ["goodbye"];
        $actual = ESArray::fold(["hello", "goodbye", "hello"])->minus(0, 2);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @not
     */
    public function testESBool()
    {
        $this->assertFalse(false);
    }

    public function testESDictionary()
    {
        $expected = [];
        $actual = ESDictionary::fold(["key" => "value", "key2" => "value2"])->minus("key", "key2");
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESInt()
    {
        $expected = 2;
        $actual = ESInt::fold(5)->minus(3);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESJson()
    {
        $expected = '{"member":"value"}';
        $actual = ESJson::fold('{"member":"value","member2":"value2"}')->minus("member2");
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESObject()
    {
        $expected = new \stdClass();
        $expected->member = "value";

        $actual = new \stdClass();
        $actual->member = "value";
        $actual->member2 = "value2";
        $actual = ESObject::fold($actual)->minus("member2");
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESString()
    {
        $expected = "He, rd";
        $actual = ESString::fold("Hello, World!")->minus("W", "l", "o", "!");
        $this->assertEquals($expected, $actual->unfold());
    }
}
