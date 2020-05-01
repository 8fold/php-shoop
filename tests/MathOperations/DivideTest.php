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
class DivideTest extends TestCase
{
    public function testESArray()
    {
        $expected = [
            ["hello"],
            ["goodbye", "hello"]
        ];
        $actual = ESArray::fold(["hello", "goodbye", "hello"])->divide(1);
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
        $expected = ["keys" => ["key", "key2"], "values" => ["value", "value2"]];
        $actual = ESDictionary::fold(["key" => "value", "key2" => "value2"])->divide("key", "key2");
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESInt()
    {
        $expected = 2;
        $actual = ESInt::fold(5)->divide(3);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESJson()
    {
        $expected = json_encode((object) ["members" => ["member", "member2"], "values" => ["value", "value2"]]);
        $actual = ESJson::fold('{"member":"value","member2":"value2"}')->divide();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESObject()
    {
        $expected = new \stdClass();
        $expected->members = ["member", "member2"];
        $expected->values = ["value", "value2"];

        $actual = new \stdClass();
        $actual->member = "value";
        $actual->member2 = "value2";
        $actual = ESObject::fold($actual)->divide();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESString()
    {
        $expected = ["Hello", "World!"];
        $actual = ESString::fold("Hello, World!")->divide(", ");
        $this->assertEquals($expected, $actual->unfold());
    }
}
