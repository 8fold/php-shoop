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
 * The `Iterator` PHP interface requires the `current()` method.
 *
 * The iterator interface mthods allow the object to be used in loops. The `current()` returns the current position, when applicable.
 *
 * @declared Eightfold\Shoop\Traits\Shoop
 *
 * @defined Eightfold\Shoop\Interfaces\ShoopedImp
 *
 * @overridden Eightfold\Shoop\ESBool, Eightfold\Shoop\ESInt
 *
 * @return bool
 */
class ArrayAccessAccessingTest extends TestCase
{
    public function testESArray()
    {
        $actual = ESArray::fold(["hello", "goodbye"]);
        $expected = [];
        foreach ($actual as $key => $value) {
            $expected[$key] = $value;
        }
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * Begins by converting to `dictionary()`.
     */
    public function testESBool()
    {
        $actual = ESBool::fold(false);
        $expectedTrue = ["true" => false];
        $expectedFalse = ["false" => true];
        $actualTrue = [];
        $actualFalse = [];
        foreach ($actual as $key => $value) {
            if ($key === "true") {
                $actualTrue["true"] = $value;

            } elseif ($key === "false") {
                $actualFalse["false"] = $value;

            }
        }
        $this->assertEquals($expectedTrue, $actualTrue);
        $this->assertEquals($expectedFalse, $actualFalse);
    }

    public function testESDictionary()
    {
        $actual = ESDictionary::fold(["one" => "hello", "two" => "goodbye"]);
        $keys = ["one", "two"];
        $values = ["hello", "goodbye"];
        $keysActual = [];
        $valuesActual = [];
        foreach ($actual as $key => $value) {
            $keysActual[] = $key;
            $valuesActual[] = $value;

        }
        $this->assertEquals($keys, $keysActual);
        $this->assertEquals($values, $valuesActual);
    }

    /**
     * Equivalent to `array()->current()`.
     */
    public function testESInt()
    {
        $actual = ESInt::fold(10)->current();
        $this->assertEquals(0, $actual);
    }

    public function testESJson()
    {
        $expected = "hello";
        $actual = ESJson::fold('{"one":"hello", "two":"goodbye"}')->current();
        $this->assertEquals($expected, $actual);
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->one = "hello";
        $base->two = "goodbye";

        $actual = ESObject::fold($base)->current();
        $this->assertEquals("hello", $actual);
    }

    public function testESString()
    {
        $expected = "c";
        $actual = ESString::fold("comp")->current();
        $this->assertEquals($expected, $actual);
    }
}
