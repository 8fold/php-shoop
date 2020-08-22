<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;



use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    ESBoolean,
    ESDictionary,
    ESInteger,
    ESJson,
    ESTuple,
    ESString
};

/**
 * All Shoop types conform to the `Iterator` interface and may be iterated over using stand PHP syntax.
 *
 * In most cases the iterator will use the array representation of the Shoop type.
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
    public function testESBoolean()
    {
        $base = ESBoolean::fold(false);

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

        $members = ["one", "two"];
        $values = ["hello", "goodbye"];

        $membersActual = [];
        $valuesActual = [];
        for ($base->rewind(); $base->valid(); $base->next()) {
            $membersActual[] = $base->key();
            $valuesActual[] = $base->current();
        }
        $this->assertEquals($members, $membersActual);
        $this->assertEquals($values, $valuesActual);
    }

    public function testESInteger()
    {
        $base = ESInteger::fold(5);

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
            $member = $base->key();
            $value = $base->current();
            $actual[$member] = $value;
        }
        $this->assertEquals($expected, $actual);
    }

    public function testESTuple()
    {
        $object = new \stdClass();
        $object->one = "hello";
        $object->two = "goodbye";

        $base = ESTuple::fold($object);

        $expected = ["one" => "hello", "two" => "goodbye"];
        $actual = [];
        for ($base->rewind(); $base->valid(); $base->next()) {
            $member = $base->key();
            $value = $base->current();
            $actual[$member] = $value;
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
