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
class MultiplyTest extends TestCase
{
    public function testESArray()
    {
        $expected = [
            ["goodbye", "hello"],
            ["goodbye", "hello"],
            ["goodbye", "hello"]
        ];
        $actual = ESArray::fold(["goodbye", "hello"])->multiply(3);
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
        $expected = [
            ["values" => ["value", "value2"]],
            ["values" => ["value", "value2"]],
            ["values" => ["value", "value2"]],
            ["values" => ["value", "value2"]],
            ["values" => ["value", "value2"]]
        ];
        $actual = ESDictionary::fold(["values" => ["value", "value2"]])->multiply(5);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESInt()
    {
        $expected = 15;
        $actual = ESInt::fold(5)->multiply(3);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESJson()
    {
        $json = json_encode((object) ["member" => "value", "member2" => "value2"]);
        $expected = [$json, $json, $json, $json];
        $actual = ESJson::fold('{"member":"value","member2":"value2"}')->multiply(4);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESObject()
    {
        $object = new \stdClass();
        $object->members = ["member", "member2"];
        $object->values = ["value", "value2"];

        $expected = [$object];
        $actual = ESObject::fold($object)->multiply();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESString()
    {
        $expected = ["Hello", "World!"];
        $actual = ESString::fold("Hello, World!")->divide(", ");
        $this->assertEquals($expected, $actual->unfold());
    }
}
