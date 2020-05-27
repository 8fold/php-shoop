<?php

namespace Eightfold\Shoop\Tests\Helpers;

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

    /**
     * The `boolToString()` method converts the value to a `PHP string`, which will either be the string "true" or an empty string.
     *
     * @return string
     */
    public function testBoolToString()
    {
        $expected = "";
        $actual = PhpTypeJuggle::boolToString(false);
        $this->assertEquals($expected, $actual);
    }

// -> Dictionary

    /**
     * The `associativeArrayToIndexedArray()` method converts a `PHP associative array` to a `PHP indexed array` using the `array_value()` function from the PHP standard library.
     *
     * @return array
     */
    public function testAssociativeArrayToIndexedArray()
    {
        $expected = ["hello", "world"];
        $actual = PhpTypeJuggle::associativeArrayToIndexedArray(["h" => "hello", "w" => "world"]);
        $this->assertEquals($expected, $actual);
    }

    /**
     * The `associativeArrayToBool()` method converts a `PHP associative array` to a `PHP bool` bsed on whether the `empty()` function from the PHP standard library return true or false.
     *
     * @return bool
     */
    public function testAssociativeArrayToBool()
    {
        $expected = false;
        $actual = PhpTypeJuggle::associativeArrayToBool([]);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @not
     */
    public function testAssociativeArrayToAssociativeArray()
    {
        $this->assertFalse(false);
    }

    /**
     * The `associativeArrayToInt()` method converts a `PHP associative array` to a `PHP integer` based on the number of members in the array.
     *
     * @return integer
     */
    public function testAssociativeArrayToInt()
    {
        $expected = 1;
        $actual = PhpTypeJuggle::associativeArrayToInt([true]);
        $this->assertEquals($expected, $actual);
    }

    /**
     * The `associativeArrayToJson()` method converts a `PHP associative array` to a `PHP object`, which is converted to a `PHP string` using the `json_encode()` function from the PHP standard library.
     *
     * @return string
     */
    public function testAssociativeArrayToJson()
    {
        $expected = '{"test":"test"}';
        $actual = PhpTypeJuggle::associativeArrayToJson(["test" => "test"]);
        $this->assertEquals($expected, $actual);
    }

    /**
     * The `associativeArrayToObject()` method converts a `PHP associative array` to a `PHP object` using the `array_value()` function from the PHP standard library.
     *
     * @return \stdClass
     */
    public function testAssociativeArrayToObject()
    {
        $expected = new \stdClass();
        $actual = PhpTypeJuggle::associativeArrayToObject();
        $this->assertEquals($expected, $actual);
    }

    /**
     * The `associativeArrayToString()` method converts a `PHP associative array` to a `PHP string` mimicks the `print_r()` function from the PHP standard library.
     *
     * @return string
     */
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

    /**
     * @see range() Always uses starting value of 0.
     *
     * @return array
     */
    public function testIntToIndexedArray()
    {
        $expected = [0, 1, 2, 3];
        $actual = PhpTypeJuggle::intToIndexedArray(3);
        $this->assertEquals($expected, $actual);
    }

    /**
     * The `intToBool()` method converts a `PHP integer` to a `PHP bool` using PHP type casting, only 0 returns false.
     */
    public function testIntToBool()
    {
        $expected = true;
        $actual = PhpTypeJuggle::intToBool(10);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @see intToIndexedArray() & indexedArrayToAssociativeArray()
     *
     * return array (associative)
     */
    public function testIntToAssociativeArray()
    {
        $expected = ["i0" => 0, "i1" => 1];
        $actual = PhpTypeJuggle::intToAssociativeArray(1);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @not
     */
    public function testIntToInt()
    {
        $this->assertFalse(false);
    }

    /**
     * @see intToObject() Return value is passed to the `json_encode()` function from the PHP standard library.
     *
     * @return string
     */
    public function testIntToJson()
    {
        $expected = '{"i0":0,"i1":1}';
        $actual = PhpTypeJuggle::intToJson(1);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @see intToAssociativeArray() Value is cast to a `PHP object`.
     *
     * @return \stdClass
     */
    public function testIntToObject()
    {
        $expected = new \stdClass();
        $expected->i0 = 0;
        $expected->i1 = 1;
        $actual = PhpTypeJuggle::intToObject(1);
        $this->assertEquals($expected, $actual);
    }

    /**
     * The `intToString()` method converts a `PHP integer` to a `PHP string` using standard PHP type casting.
     *
     * @return string
     */
    public function testIntToString()
    {
        $expected = "1";
        $actual = PhpTypeJuggle::intToString(1);
        $this->assertEquals($expected, $actual);
    }

// -> Json

    /**
     * @see jsonToObject() & objectToIndexedArray()
     *
     * @return array
     */
    public function testJsonToIndexedArray()
    {
        $expected = ["hello", "world"];
        $actual = PhpTypeJuggle::jsonToIndexedArray('{"h":"hello","w":"world"}');
        $this->assertEquals($expected, $actual);
    }

    /**
     * @see jsonToObject() & objectToBool()
     *
     * @return bool
     */
    public function testJsonToBool()
    {
        $expected = false;
        $actual = PhpTypeJuggle::jsonToBool('{}');
        $this->assertEquals($expected, $actual);
    }

    /**
     * @see jsonToObject() & objectToAssociativeArray()
     *
     * @return array (associative)
     */
    public function testJsonToAssociativeArray()
    {
        $expected = ["test" => "value"];
        $actual = PhpTypeJuggle::jsonToAssociativeArray('{"test":"value"}');
        $this->assertEquals($expected, $actual);
    }

    /**
     * @see jsonToObject() & objectToInt()
     *
     * @return integer
     */
    public function testJsonToInt()
    {
        $expected = 2;
        $actual = PhpTypeJuggle::jsonToInt('{"test":"value","test2":"value2"}');
        $this->assertEquals($expected, $actual);
    }

    /**
     * @not
     */
    public function testJsonToJson()
    {
        $this->assertFalse(false);
    }

    /**
     * The `jsonToObject()` converts a `PHP string` to a `PHP object` using the `json_decode()` function from the PHP standard library.
     *
     * @return \stdClass
     */
    public function testJsonToObject()
    {
        $expected = new \stdClass();
        $actual = PhpTypeJuggle::jsonToObject('{}');
        $this->assertEquals($expected, $actual);
    }

    /**
     * @not
     */
    public function testJsonToString()
    {
        $this->assertFalse(false);
    }

// -> Object

    /**
     * @see objectToAssociativeArray() & associativeArrayToIndexedArray()
     *
     * @return array
     */
    public function testObjectToIndexedArray()
    {
        $expected = ["hello", "world"];
        $actual = new \stdClass();
        $actual->h = "hello";
        $actual->w = "world";
        $actual = PhpTypeJuggle::objectToIndexedArray($actual);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @see objectToAssociativeArray() & associativeArrayToBool()
     *
     * @return bool
     */
    public function testObjectToBool()
    {
        $expected = false;
        $actual = new \stdClass();
        $actual = PhpTypeJuggle::objectToBool($actual);
        $this->assertEquals($expected, $actual);
    }

    /**
     * The `objectToAssociativeArray()` converts a `PHP object` to a `PHP associative array` using PHP type casting.
     *
     * @return array (associative)
     */
    public function testObjectToAssociativeArray()
    {
        $expected = ["h" => "hello", "w" => "world"];
        $actual = new \stdClass();
        $actual->h = "hello";
        $actual->w = "world";
        $actual = PhpTypeJuggle::objectToAssociativeArray($actual);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @see objectToAssociativeArray() & associativeArrayToInt()
     *
     * @return integer
     */
    public function testObjectToInt()
    {
        $expected = 2;
        $actual = new \stdClass();
        $actual->h = "hello";
        $actual->w = "world";
        $actual = PhpTypeJuggle::objectToInt($actual);
        $this->assertEquals($expected, $actual);
    }

    /**
     * The `objectToJson()` method converts a `PHP object` to a `PHP string` conforming to JavaScript Object Notation using the `json_encode()` function from the PHP standard library.
     *
     * @return string (JSON)
     */
    public function testObjectToJson()
    {
        $expected = '{"h":"hello","w":"world"}';
        $actual = new \stdClass();
        $actual->h = "hello";
        $actual->w = "world";
        $actual = PhpTypeJuggle::objectToJson($actual);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @not
     */
    public function testObjectToObject()
    {
        $this->assertFalse(false);
    }

    /**
     * The `objectToString()` method converts a `PHP object` to a `PHP string` similar to the way the `print_r()` function from the PHP standard library would.
     *
     * @return string
     */
    public function testObjectToString()
    {
        $expected = "stdClass Object()";
        $actual = new \stdClass();
        $actual = PhpTypeJuggle::objectToString($actual);
        $this->assertEquals($expected, $actual);
    }

// -> String

    /**
     * The `stringToIndexedArray()` method converts a `PHP string` to a `PHP array` with one value per character in the original string.
     *
     * @return string
     */
    public function testStringToIndexedArray()
    {
        $expected = ["h", "e", "l", "l", "o"];
        $actual = PhpTypeJuggle::stringToIndexedArray("hello");
        $this->assertEquals($expected, $actual);
    }

    /**
     * The `stringToBool()` methods converts a `PHP string` to a `PHP bool` using the `empty()` function from the PHP standard library where empty string returns false.
     *
     * @return bool
     */
    public function testStringToBool()
    {
        $expected = true;
        $actual = PhpTypeJuggle::stringToBool("hello");
        $this->assertEquals($expected, $actual);
    }

    /**
     * @see stringToIndexedArray() & indexedArrayToAssociativeArray()
     *
     * @return array (associative)
     */
    public function testStringToAssociativeArray()
    {
        $expected = ["i0" => "h", "i1" => "i"];
        $actual = PhpTypeJuggle::stringToAssociativeArray("hi");
        $this->assertEquals($expected, $actual);
    }

    /**
     * The `stringToInt()` method converts a `PHP string` to the equivalent `PHP integer` using the `intval()` function from the PHP standard library.
     *
     * @return integer
     */
    public function testStringToInt()
    {
        $expected = 3;
        $actual = PhpTypeJuggle::stringToInt("3");
        $this->assertEquals($expected, $actual);
    }

    /**
     * @not
     */
    public function testStringToJson()
    {
        $this->assertFalse(false);
    }

    /**
     * The `stringToObject()` method creates a `PHP object` with a `string` member with the value of the original `PHP string`.
     * @return [type] [description]
     */
    public function testStringToObject()
    {
        $expected = new \stdClass();
        $expected->string = "Hello!";
        $actual = PhpTypeJuggle::stringToObject("Hello!");
        $this->assertEquals($expected, $actual);
    }

    /**
     * @not
     */
    public function testStringToString()
    {
        $this->assertFalse(false);
    }
}
