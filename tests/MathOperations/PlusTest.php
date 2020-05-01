<?php

namespace Eightfold\Shoop\Tests\MathOperations;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\{
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
class PlusTest extends TestCase
{
    public function testESArray()
    {
        $expected = ["hello", "goodbye"];
        $actual = ESArray::fold([])->plus("hello", "goodbye");
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
        $expected = ["key" => "value", "key2" => "value2"];
        $actual = ESDictionary::fold([])->plus("value", "key", "value2", "key2");
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESInt()
    {
        $expected = 8;
        $actual = ESInt::fold(5)->plus(3);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESJson()
    {
        $expected = '{"member":"value","member2":"value2"}';
        $actual = ESJson::fold('{"member":"value"}')->plus("value2", "member2");
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESObject()
    {
        $expected = new \stdClass();
        $expected->member = "value";
        $expected->member2 = "value2";
        $actual = ESObject::fold(new \stdClass())->plus("value", "member", "value2", "member2");
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESString()
    {
        $expected = "Hello, World!";
        $actual = ESString::fold("Hello")->plus(", ", "World", "!");
        $this->assertEquals($expected, $actual->unfold());
    }
}
