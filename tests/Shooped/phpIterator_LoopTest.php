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
 * All `Shoop types` conform to the `Iterator interface` from the PHP standard library.
 *
 * In most cases the iterator will use the array representation of the `Shoop type`.
 */
class InterfaceIteratorLoopTest extends TestCase
{
    public function testESArray()
    {
        $base = ESArray::fold(["hello", "goodbye"]);
        $expected = ["hello", "goodbye"];
        $actual = [];
        for ($base->rewind(); $base->valid(); $base->next()) {
            $actual[] = $base->current();
        }
        $this->assertEquals($expected, $actual);
    }

    /**
     * Uses ESDicionary
     */
    public function testESBool()
    {
        $base = ESBool::fold(false);

        $expectedTrue = ["true" => false];
        $expectedFalse = ["false" => true];
        $actualTrue = [];
        $actualFalse = [];
        for ($base->rewind(); $base->valid(); $base->next()) {
            if ($base->key() === "true") {
                $actualTrue["true"] = $base->current();

            } else {
                $actualFalse["false"] = $base->current();

            }
        }
        $this->assertEquals($expectedTrue, $actualTrue);
        $this->assertEquals($expectedFalse, $actualFalse);
    }

    public function testESDictionary()
    {
        $base = ESDictionary::fold(["one" => "hello", "two" => "goodbye"]);

        $keys = ["one", "two"];
        $values = ["hello", "goodbye"];

        $keysActual = [];
        $valuesActual = [];
        for ($base->rewind(); $base->valid(); $base->next()) {
            $keysActual[] = $base->key();
            $valuesActual[] = $base->current();
        }
        $this->assertEquals($keys, $keysActual);
        $this->assertEquals($values, $valuesActual);
    }

    public function testESInt()
    {
        $base = ESInt::fold(5);

        $expected = [0, 1, 2, 3, 4, 5];
        $actual = [];
        for ($base->rewind(); $base->valid(); $base->next()) {
            $actual[] = $base->current();
        }
        $this->assertEquals($expected, $actual);
    }

    public function testESJson()
    {
        $base = ESJson::fold('{"one":"hello", "two":"goodbye"}');
        $expected = ["one" => "hello", "two" => "goodbye"];
        $actual = [];
        for ($base->rewind(); $base->valid(); $base->next()) {
            $key = $base->key();
            $value = $base->current();
            $actual[$key] = $value;
        }
        $this->assertEquals($expected, $actual);
    }

    public function testESObject()
    {
        $object = new \stdClass();
        $object->one = "hello";
        $object->two = "goodbye";

        $base = ESObject::fold($object);

        $expected = ["one" => "hello", "two" => "goodbye"];
        $actual = [];
        for ($base->rewind(); $base->valid(); $base->next()) {
            $key = $base->key();
            $value = $base->current();
            $actual[$key] = $value;
        }
        $this->assertEquals($expected, $actual);
    }

    public function testESString()
    {
        $base = ESString::fold("comp");
        $expected = "comp";
        $actual = "";
        for ($base->rewind(); $base->valid(); $base->next()) {
            $actual .= $base->current();
        }
        $this->assertEquals($expected, $actual);
    }
}
