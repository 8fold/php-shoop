<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;



use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    ESBoolean,
    ESDictionary,
    ESInt,
    ESJson,
    ESObject,
    ESString
};

/**
 * The `current()` method from the `Iterator` interface returns the value of the member being pointed to.
 *
 * @return mixed
 *   - If the value is a PHP type, it will be converted to the equivalent Shoop type.
 *   - If the value coforms to the `Shooped` interfac`, the instance is returned.
 *   - Otherwise, the raw value is returned (instances of non-Shoop types or class, for example.
 *
 */
class InterfaceIteratorCurrentTest extends TestCase
{
    public function testESArray()
    {
        $expected = "hello";
        $actual = ESArray::fold(["hello", "goodbye"])->current();
        $this->assertEquals($expected, $actual);
    }

    public function testESBoolean()
    {
        $actual = ESBoolean::fold(true)->current();
        $this->assertTrue($actual);
    }

    public function testESDictionary()
    {
        $expected = "hello";
        $actual = ESDictionary::fold(["one" => "hello", "two" => "goodbye"])->current();
        $this->assertEquals($expected, $actual);
    }

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
