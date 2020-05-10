<?php

namespace Eightfold\Shoop\Tests\Wrap;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Helpers\PhpTypeJuggle;

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

class PhpTypeJugglingTest extends TestCase
{
// -> Indexed Array

    /**
     * The `indexedArrayToIndexedArray()` method converts a `PHP indexed array` to a `PHP indexed array`.
     *
     * @return array
     */
    public function testIndexedArrayToIndexedArray()
    {
        $this->assertFalse(false);
    }

    /**
     * The `indexedArrayToBool()` method converts a `PHP indexed array` to a `PHP bool` using the `empty()` function from the PHP standard library.
     *
     * @return array
     */
    public function testIndexedArrayToBool()
    {
        $expected = false;
        $actual = PhpTypeJuggle::indexedArrayToBool([]);
        $this->assertEquals($expected, $actual);
    }

    /**
     * The `indexedArrayToAssociativeArray()` method converts a `PHP indexed array` to a `PHP associative array` by prepending the indexes with a lowercase "i".
     *
     * @return array
     */
    public function testIndexedArrayToAssociativeArray()
    {
        $expected = ["i0" => 0, "i1" => 1];
        $actual = PhpTypeJuggle::indexedArrayToAssociativeArray([0, 1]);
        $this->assertEquals($expected, $actual);
    }

    /**
     * The `indexedArrayToInt()` method converts a `PHP indexed array` to a `PHP integer` using the `count()` function from the PHP standard library.
     *
     * @return array
     */
    public function testIndexedArrayToInt()
    {
        $expected = 3;
        $actual = PhpTypeJuggle::indexedArrayToInt(["hello", 2, true]);
        $this->assertEquals($expected, $actual);
    }

    /**
     * The `indexedArrayToJson()` method converts a `PHP indexed array` to a `PHP associative array`, which is converted to a `PHP string` using JavaScript Object Notation.
     *
     * @return array
     */
    public function testIndexedArrayToJson()
    {
        $expected = '{"i0":0}';
        $actual = PhpTypeJuggle::indexedArrayToJson([0]);
        $this->assertEquals($expected, $actual);
    }

    /**
     * The `indexedArrayToObject()` method converts a `PHP indexed array` to a `PHP associative array`, which is converted to a `PHP object`.
     *
     * @return array
     */
    public function testIndexedArrayToObject()
    {
        $expected = new \stdClass();
        $expected->i0 = "test";
        $actual = PhpTypeJuggle::indexedArrayToObject(["test"]);
        $this->assertEquals($expected, $actual);
    }

    /**
     * The `indexedArrayToString()` method converts a `PHP indexed array` to a `PHP String` mimicking the `print_r()` function from the PHP standard library.
     *
     * @return array
     */
    public function testIndexArrayToString()
    {
        $expected = "Array([0] => 0, [1] => 1, [2] => 2)";
        $actual = PhpTypeJuggle::indexedArrayToString([0, 1, 2]);
        $this->assertEquals($expected, $actual);
    }

// -> Bool

    /**
     * The `boolToIndexedArray()` method wraps the given bool with a `PHP indexed array`.
     *
     * @return array
     */
    public function testBoolToIndexedArray()
    {
        $expected = [true];
        $actual = PhpTypeJuggle::boolToIndexedArray(true);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @not
     */
    public function testBoolToBool()
    {
        $this->assertFalse(false);
    }

    /**
     * The `boolToAssociativeArray()` method creates a `PHP associative array` with two members ("true" and "false"), the values for the members will be based on the original value of the object.
     *
     * @return array (associative)
     */
    public function testBoolToAssociativeArray()
    {
        $expected = ["true" => false, "false" => true];
        $actual = PhpTypeJuggle::boolToAssociativeArray(false);
        $this->assertEquals($expected, $actual);
    }

    /**
     * The `boolToInt()` method converts the original value to a `PHP integer` with a value of 1 or 0 based on whether the original value was true or false, respectively.
     *
     * @return integer
     */
    public function testBoolToInt()
    {
        $expected = 0;
        $actual = PhpTypeJuggle::boolToInt(false);
        $this->assertEquals($expected, $actual);
    }

    /**
     * The `boolToJson()` method converts the value to a `PHP associative array`, then to a `PHP object`, and then performs the `json_encode()` function from the standard library on the object.
     *
     * @return string (JSON)
     */
    public function testBoolToJson()
    {
        $expected = '{"true":true,"false":false}';
        $actual = PhpTypeJuggle::boolToJson(true);
        $this->assertEquals($expected, $actual);
    }

    /**
     * The `boolToJson()` method converts the value to a `PHP associative array`, then to a `PHP object`.
     *
     * @return \stdClass
     */
    public function testBoolToObject()
    {
        $expected = new \stdClass();
        $expected->true = false;
        $expected->false = true;
        $actual = PhpTypeJuggle::boolToObject(false);
        $this->assertEquals($expected, $actual);
    }

    public function testBoolToString()
    {
        $expected = "";
        $actual = PhpTypeJuggle::boolToString(false);
        $this->assertEquals($expected, $actual);
    }

// -> Dictionary
    public function testAssociativeArrayToIndexedArray()
    {
        $expected = ["hello", "world"];
        $actual = PhpTypeJuggle::associativeArrayToIndexedArray(["h" => "hello", "w" => "world"]);
        $this->assertEquals($expected, $actual);
    }

    public function testAssociativeArrayToBool()
    {
        $expected = false;
        $actual = PhpTypeJuggle::associativeArrayToBool([]);
        $this->assertEquals($expected, $actual);
    }

    public function testAssociativeArrayToAssociativeArray()
    {
        $this->assertFalse(false);
    }

    public function testAssociativeArrayToInt()
    {
        $expected = 1;
        $actual = PhpTypeJuggle::associativeArrayToInt([true]);
        $this->assertEquals($expected, $actual);
    }

    public function testAssociativeArrayToJson()
    {
        $expected = '{"test":"test"}';
        $actual = PhpTypeJuggle::associativeArrayToJson(["test" => "test"]);
        $this->assertEquals($expected, $actual);
    }

    public function testAssociativeArrayToObject()
    {
        $expected = new \stdClass();
        $actual = PhpTypeJuggle::associativeArrayToObject();
        $this->assertEquals($expected, $actual);
    }

    public function testAssociativeArrayToString()
    {
        $expected = "Dictionary([zero] => Hello, [one] => ,, [two] => World!)";
        $actual = PhpTypeJuggle::associativeArrayToString([
            "zero" => "Hello",
            "one" => ", ",
            "two" => "World!"
        ]);
        $this->assertEquals($expected, $actual);
    }

// -> Int
    public function testIntToIndexedArray()
    {
        $expected = [0, 1, 2, 3];
        $actual = PhpTypeJuggle::intToIndexedArray(3);
        $this->assertEquals($expected, $actual);
    }

    public function testIntToBool()
    {
        $expected = true;
        $actual = PhpTypeJuggle::intToBool(10);
        $this->assertEquals($expected, $actual);
    }

    public function testIntToAssociativeArray()
    {
        $expected = ["i0" => 0, "i1" => 1];
        $actual = PhpTypeJuggle::intToAssociativeArray(1);
        $this->assertEquals($expected, $actual);
    }

    public function testIntToInt()
    {
        $this->assertFalse(false);
    }

    public function testIntToJson()
    {
        $expected = '{"i0":0,"i1":1}';
        $actual = PhpTypeJuggle::intToJson(1);
        $this->assertEquals($expected, $actual);
    }

    public function testIntToObject()
    {
        $expected = new \stdClass();
        $expected->i0 = 0;
        $expected->i1 = 1;
        $actual = PhpTypeJuggle::intToObject(1);
        $this->assertEquals($expected, $actual);
    }

    public function testIntToString()
    {
        $expected = "1";
        $actual = PhpTypeJuggle::intToString(1);
        $this->assertEquals($expected, $actual);
    }

// -> Json
    public function testJsonToIndexedArray()
    {
        $expected = ["hello", "world"];
        $actual = PhpTypeJuggle::jsonToIndexedArray('{"h":"hello","w":"world"}');
        $this->assertEquals($expected, $actual);
    }

    public function testJsonToBool()
    {
        $expected = false;
        $actual = PhpTypeJuggle::jsonToBool('{}');
        $this->assertEquals($expected, $actual);
    }

    public function testJsonToAssociativeArray()
    {
        $expected = ["test" => "value"];
        $actual = PhpTypeJuggle::jsonToAssociativeArray('{"test":"value"}');
        $this->assertEquals($expected, $actual);
    }

    public function testJsonToInt()
    {
        $expected = 2;
        $actual = PhpTypeJuggle::jsonToInt('{"test":"value","test2":"value2"}');
        $this->assertEquals($expected, $actual);
    }

    public function testJsonToJson()
    {
        $this->assertFalse(false);
    }

    public function testJsonToObject()
    {
        $expected = new \stdClass();
        $actual = PhpTypeJuggle::jsonToObject('{}');
        $this->assertEquals($expected, $actual);
    }

    public function testJsonToString()
    {
        $this->assertFalse(false);
    }

// -> Object
    public function testObjectToIndexedArray()
    {
        $expected = ["hello", "world"];
        $actual = new \stdClass();
        $actual->h = "hello";
        $actual->w = "world";
        $actual = PhpTypeJuggle::objectToIndexedArray($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testObjectToBool()
    {
        $expected = false;
        $actual = new \stdClass();
        $actual = PhpTypeJuggle::objectToBool($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testObjectToAssociativeArray()
    {
        $expected = ["h" => "hello", "w" => "world"];
        $actual = new \stdClass();
        $actual->h = "hello";
        $actual->w = "world";
        $actual = PhpTypeJuggle::objectToAssociativeArray($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testObjectToInt()
    {
        $expected = 2;
        $actual = new \stdClass();
        $actual->h = "hello";
        $actual->w = "world";
        $actual = PhpTypeJuggle::objectToInt($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testObjectToJson()
    {
        $expected = '{"h":"hello","w":"world"}';
        $actual = new \stdClass();
        $actual->h = "hello";
        $actual->w = "world";
        $actual = PhpTypeJuggle::objectToJson($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testObjectToObject()
    {
        $this->assertFalse(false);
    }

    public function testObjectToString()
    {
        $expected = "stdClass Object()";
        $actual = new \stdClass();
        $actual = PhpTypeJuggle::objectToString($actual);
        $this->assertEquals($expected, $actual);
    }

// -> String
    public function testStringToIndexedArray()
    {
        $expected = ["h", "e", "l", "l", "o"];
        $actual = PhpTypeJuggle::stringToIndexedArray("hello");
        $this->assertEquals($expected, $actual);
    }

    public function testStringToBool()
    {
        $expected = true;
        $actual = PhpTypeJuggle::stringToBool("hello");
        $this->assertEquals($expected, $actual);
    }

    public function testStringToAssociativeArray()
    {
        $expected = ["i0" => "h", "i1" => "i"];
        $actual = PhpTypeJuggle::stringToAssociativeArray("hi");
        $this->assertEquals($expected, $actual);
    }

    public function testStringToInt()
    {
        $expected = 3;
        $actual = PhpTypeJuggle::stringToInt("3");
        $this->assertEquals($expected, $actual);
    }

    public function testStringToJson()
    {
        $this->assertFalse(false);
    }

    public function testStringToObject()
    {
        $expected = new \stdClass();
        $expected->string = "Hello!";
        $actual = PhpTypeJuggle::stringToObject("Hello!");
        $this->assertEquals($expected, $actual);
    }

    public function testStringToString()
    {
        $this->assertFalse(false);
    }
}
