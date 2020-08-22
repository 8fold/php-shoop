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
 * The `key()` method from the `Iterator` interface returns the member currently being pointed to.
 *
 * @return mixed If the value is a PHP type, it will be converted to the equivalent Shoop type.
 */
class InterfaceIteratorKeyTest extends TestCase
{
    public function ESArray()
    {
        $expected = 0;
        $actual = ESArray::fold(["hello", "goodbye"])->key();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Equivalent to `dictionary()->key()`.
     */
    public function ESBoolean()
    {
        $actual = ESBoolean::fold(true)->key();
        $this->assertEquals("true", $actual);
    }

    public function ESDictionary()
    {
        $expected = "two";
        $actual = ESDictionary::fold(["one" => "hello", "two" => "goodbye"]);
        $actual->next();
        $this->assertEquals($expected, $actual->key());
    }

    /**
     * Resets value to original value.
     */
    public function ESInteger()
    {
        $actual = ESInteger::fold(10);
        $this->assertEquals(10, $actual->unfold());
    }

    public function ESJson()
    {
        $expected = "two";
        $actual = ESJson::fold('{"one":"hello", "two":"goodbye"}');
        $actual->next();
        $this->assertEquals($expected, $actual->key());
    }

    public function ESTuple()
    {
        $base = new \stdClass();
        $base->one = "hello";
        $base->two = "goodbye";

        $actual = ESTuple::fold($base);
        $this->assertEquals("one", $actual->key());
    }

    public function ESString()
    {
        $expected = 0;
        $actual = ESString::fold("comp");
        $this->assertEquals($expected, $actual->key());
    }
}
