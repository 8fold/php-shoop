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
class ArrayAccessAccessTest extends TestCase
{
    public function testESArray()
    {
        $actual = ESArray::fold(["hello", "goodbye"]);
        $this->assertEquals("goodbye", $actual[1]);
    }

    public function testESBool()
    {
        $actual = ESBool::fold(false);
        $this->assertFalse($actual["true"]);
        $this->assertTrue($actual["false"]);
    }

    public function testESDictionary()
    {
        $actual = ESDictionary::fold(["one" => "hello", "two" => "goodbye"]);
        $this->assertEquals("hello", $actual["one"]);
        $this->assertEquals("goodbye", $actual["two"]);
    }

    public function testESInt()
    {
        $actual = ESInt::fold(10);
        $this->assertEquals(1, $actual[1]);
        $this->assertEquals(10, $actual[10]);
    }

    public function testESJson()
    {
        $actual = ESJson::fold('{"one":"hello", "two":"goodbye"}');
        $this->assertEquals("hello", $actual["one"]);
        $this->assertEquals("goodbye", $actual["two"]);
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->one = "hello";
        $base->two = "goodbye";

        $actual = ESObject::fold($base);
        $this->assertEquals("hello", $actual["one"]);
        $this->assertEquals("goodbye", $actual["two"]);
    }

    public function testESString()
    {
        $expected = "c";
        $actual = ESString::fold("comp");
        $this->assertEquals($expected, $actual[0]);
    }
}
