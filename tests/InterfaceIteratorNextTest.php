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

    /**
     * Equivalent to `array()->next()`.
     */
    public function testESBool()
    {
        $actual = ESBool::fold(true);
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

    /**
     * Equivalent to `array()->next()`.
     */
    public function testESInt()
    {
        $actual = ESInt::fold(10);
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
