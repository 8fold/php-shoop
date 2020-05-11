<?php

namespace Eightfold\Shoop\Tests\Shooped;

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
 * All `Shoop types` conform to the `ArrayAccess` interface from the PHP standard library; therefore, can be interacted with as if they were arrays.
 *
 * @return multiple
 */
class ArrayAccessAccessingTest extends TestCase
{
    public function testESArray()
    {
        $array = ESArray::fold(["hello", "goodbye"]);

        $expected = ["hello", "goodbye"];
        $actual = [];
        foreach ($array as $member => $value) {
            $actual[$member] = $value;
        }
        $this->assertEquals($expected, $actual);

        $this->assertEquals("goodbye", $array[1]);
    }

    public function testESBool()
    {
        $bool = ESBool::fold(false);

        $expectedTrue = ["true" => false];
        $expectedFalse = ["false" => true];
        $actualTrue = [];
        $actualFalse = [];
        foreach ($bool as $member => $value) {
            if ($member === "true") {
                $actualTrue["true"] = $value;

            } elseif ($member === "false") {
                $actualFalse["false"] = $value;

            }
        }
        $this->assertEquals($expectedTrue, $actualTrue);
        $this->assertEquals($expectedFalse, $actualFalse);

        $this->assertFalse($bool["true"]);
        $this->assertTrue($bool["false"]);
    }

    public function testESDictionary()
    {
        $dictionary = ESDictionary::fold(["one" => "hello", "two" => "goodbye"]);

        $members = ["one", "two"];
        $values = ["hello", "goodbye"];
        $membersActual = [];
        $valuesActual = [];
        foreach ($dictionary as $member => $value) {
            $membersActual[] = $member;
            $valuesActual[] = $value;

        }
        $this->assertEquals($members, $membersActual);
        $this->assertEquals($values, $valuesActual);

        $this->assertEquals($dictionary->unfold()["one"], $dictionary["one"]);
    }

    public function testESInt()
    {
        $integer = ESInt::fold(3);

        $expected = [0, 1, 2, 3];
        $actual = [];
        foreach ($integer as $int) {
            $actual[] = $int;
        }
        $this->assertEquals($expected, $actual);

        $this->assertEquals($expected[2], $integer[2]);
    }

    public function testESJson()
    {
        $json = ESJson::fold('{"one":"hello", "two":"goodbye"}');

        $expected = ["one" => "hello", "two" => "goodbye"];
        $actual = [];
        foreach ($json as $member => $value) {
            $actual[$member] = $value;
        }
        $this->assertEquals($expected, $actual);

        $this->assertEquals($expected["one"], $json["one"]);
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->one = "hello";
        $base->two = "goodbye";

        $object = ESObject::fold($base);

        $expected = ["one" => "hello", "two" => "goodbye"];
        $actual = [];
        foreach ($object as $member => $value) {
            $actual[$member] = $value;
        }
        $this->assertEquals($expected, $actual);

        $this->assertEquals($expected["two"], $object["two"]);
    }

    public function testESString()
    {
        $string = ESString::fold("comp");
        $expected = ["c", "o", "m", "p"];
        $actual = [];
        foreach ($string as $char) {
            $actual[] = $char;
        }
        $this->assertEquals($expected, $actual);

        $this->assertEquals("c", $string[0]);
    }
}
