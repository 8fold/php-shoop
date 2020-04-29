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
class InterfaceIteratorCurrentTest extends TestCase
{
    public function testESArray()
    {
        $expected = "hello";
        $actual = ESArray::fold(["hello", "goodbye"])->current();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Equivalent to `dictionary()->current()`.
     */
    public function testESBool()
    {
        $actual = ESBool::fold(true)->current();
        $this->assertTrue($actual);
    }

    public function testESDictionary()
    {
        $expected = "hello";
        $actual = ESDictionary::fold(["one" => "hello", "two" => "goodbye"])->current();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Equivalent to `array()->current()`.
     */
    public function testESInt()
    {
        $actual = ESInt::fold(10)->current();
        $this->assertEquals(1, $actual);
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
