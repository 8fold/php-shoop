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
    ESObject,
    ESString
};

/**
 * The `next()` method from the `Iterator` interface moves the pointer to the next member of the object that conforming to the `Iterator` interface.
 */
class InterfaceIteratorNextTest extends TestCase
{
    public function testESArray()
    {
        $expected = "goodbye";
        $actual = ESArray::fold(["hello", "goodbye"]);
        $actual->next();
        $actual = $actual->current();
        $this->assertEquals($expected, $actual);
    }

    public function testESBoolean()
    {
        $actual = ESBoolean::fold(true);
        $actual->next();
        $this->assertFalse($actual->current());
    }

    public function testESDictionary()
    {
        $expected = "goodbye";
        $actual = ESDictionary::fold(["one" => "hello", "two" => "goodbye"]);
        $actual->next();
        $actual = $actual->current();
        $this->assertEquals($expected, $actual);
    }

    public function testESInteger()
    {
        $actual = ESInteger::fold(10);
        $actual->next();
        $this->assertEquals(1, $actual->current());
    }

    public function testESJson()
    {
        $expected = "goodbye";
        $actual = ESJson::fold('{"one":"hello", "two":"goodbye"}');
        $actual->next();
        $actual = $actual->current();
        $this->assertEquals($expected, $actual);
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->one = "hello";
        $base->two = "goodbye";

        $actual = ESObject::fold($base);
        $actual->next();
        $actual = $actual->current();
        $this->assertEquals("goodbye", $actual);
    }

    public function testESString()
    {
        $expected = "o";
        $actual = ESString::fold("comp");
        $actual->next();
        $actual = $actual->current();
        $this->assertEquals($expected, $actual);
    }
}
