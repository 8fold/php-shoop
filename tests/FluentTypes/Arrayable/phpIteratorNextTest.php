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
 * The `next()` method from the `Iterator` interface moves the pointer to the next member of the object that conforming to the `Iterator` interface.
 */
class InterfaceIteratorNextTest extends TestCase
{
    public function ESArray()
    {
        $expected = "goodbye";
        $actual = ESArray::fold(["hello", "goodbye"]);
        $actual->next();
        $actual = $actual->current();
        $this->assertEquals($expected, $actual);
    }

    public function ESBoolean()
    {
        $actual = ESBoolean::fold(true);
        $actual->next();
        $this->assertFalse($actual->current());
    }

    public function ESDictionary()
    {
        $expected = "goodbye";
        $actual = ESDictionary::fold(["one" => "hello", "two" => "goodbye"]);
        $actual->next();
        $actual = $actual->current();
        $this->assertEquals($expected, $actual);
    }

    public function ESInteger()
    {
        $actual = ESInteger::fold(10);
        $actual->next();
        $this->assertEquals(1, $actual->current());
    }

    public function ESJson()
    {
        $expected = "goodbye";
        $actual = ESJson::fold('{"one":"hello", "two":"goodbye"}');
        $actual->next();
        $actual = $actual->current();
        $this->assertEquals($expected, $actual);
    }

    public function ESTuple()
    {
        $base = new \stdClass();
        $base->one = "hello";
        $base->two = "goodbye";

        $actual = ESTuple::fold($base);
        $actual->next();
        $actual = $actual->current();
        $this->assertEquals("goodbye", $actual);
    }

    public function ESString()
    {
        $expected = "o";
        $actual = ESString::fold("comp");
        $actual->next();
        $actual = $actual->current();
        $this->assertEquals($expected, $actual);
    }
}
