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
 * The `rewind()` method from the `Iterator interface` from the PHP standard library moves the pointer to the beginning of the object that conforms to the `Iterator interface`.
 */
class InterfaceIteratorRewindTest extends TestCase
{
    public function testESArray()
    {
        $expected = "goodbye";
        $actual = ESArray::fold(["hello", "goodbye"]);
        $actual->next();
        $goodbye = $actual->current();
        $this->assertEquals($expected, $goodbye);

        $actual->rewind();
        $this->assertEquals("hello", $actual->current());
    }

    public function testESBool()
    {
        $actual = ESBool::fold(true);
        $actual->next(); // false
        $actual->rewind(); // true
        $this->assertTrue($actual->current());
    }

    public function testESDictionary()
    {
        $expected = "hello";
        $actual = ESDictionary::fold(["one" => "hello", "two" => "goodbye"]);
        $actual->next();
        $actual->rewind();
        $this->assertEquals($expected, $actual->current());
    }

    public function testESInt()
    {
        $actual = ESInt::fold(10);
        $actual->next();
        $this->assertEquals(1, $actual->current());

        $actual->rewind();
        $this->assertEquals(0, $actual->current());
    }

    public function testESJson()
    {
        $expected = "hello";
        $actual = ESJson::fold('{"one":"hello", "two":"goodbye"}');
        $actual->next();
        $actual->rewind();
        $this->assertEquals($expected, $actual->current());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->one = "hello";
        $base->two = "goodbye";

        $actual = ESObject::fold($base);
        $actual->next();
        $actual->rewind();
        $this->assertEquals("hello", $actual->current());
    }

    public function testESString()
    {
        $expected = "c";
        $actual = ESString::fold("comp");
        $actual->next();
        $actual->rewind();
        $this->assertEquals($expected, $actual->current());
    }
}
