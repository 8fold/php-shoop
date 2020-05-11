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
 * The `multiply()` method for most `Shoop types` duplicates the original value and returns an array as the result.
 */
class MultiplyTest extends TestCase
{
    /**
     * @return Eightfold\Shoop\ESArray Where each index is a copy of the original array.
     */
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

    /**
     * @see ESArray->multiply()
     */
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

    /**
     * @return Eightfold\Shoop\Int Where the original value is multiplied by the given integer.
     */
    public function testESInt()
    {
        $expected = 15;
        $actual = ESInt::fold(5)->multiply(3);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see ESDictionary->multiply() Where each index is the original JSON string.
     */
    public function testESJson()
    {
        $json = json_encode((object) ["member" => "value", "member2" => "value2"]);
        $expected = [$json, $json, $json, $json];
        $actual = ESJson::fold('{"member":"value","member2":"value2"}')->multiply(4);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see  ESDictionary->multiply() Where each index is an instance of the object.
     */
    public function testESObject()
    {
        $object = new \stdClass();
        $object->members = ["member", "member2"];
        $object->values = ["value", "value2"];

        $expected = [$object];
        $actual = ESObject::fold($object)->multiply();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * Uses the `str_repeat()` function from the PHP standard library to generate a string that repeats using the original value.
     */
    public function testESString()
    {
        $expected = "Hello, World!Hello, World!";
        $actual = ESString::fold("Hello, World!")->multiply(2);
        $this->assertEquals($expected, $actual->unfold());
    }
}
