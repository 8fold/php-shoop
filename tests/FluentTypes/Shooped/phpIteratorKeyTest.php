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
 * The `key()` method from the `Iterator` interface returns the member currently being pointed to.
 *
 * @return mixed If the value is a PHP type, it will be converted to the equivalent Shoop type.
 */
class InterfaceIteratorKeyTest extends TestCase
{
    public function testESArray()
    {
        $expected = 0;
        $actual = ESArray::fold(["hello", "goodbye"])->key();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Equivalent to `dictionary()->key()`.
     */
    public function testESBool()
    {
        $actual = ESBool::fold(true)->key();
        $this->assertEquals("true", $actual);
    }

    public function testESDictionary()
    {
        $expected = "two";
        $actual = ESDictionary::fold(["one" => "hello", "two" => "goodbye"]);
        $actual->next();
        $this->assertEquals($expected, $actual->key());
    }

    /**
     * Resets value to original value.
     */
    public function testESInt()
    {
        $actual = ESInt::fold(10);
        $this->assertEquals(10, $actual->unfold());
    }

    public function testESJson()
    {
        $expected = "two";
        $actual = ESJson::fold('{"one":"hello", "two":"goodbye"}');
        $actual->next();
        $this->assertEquals($expected, $actual->key());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->one = "hello";
        $base->two = "goodbye";

        $actual = ESObject::fold($base);
        $this->assertEquals("one", $actual->key());
    }

    public function testESString()
    {
        $expected = 0;
        $actual = ESString::fold("comp");
        $this->assertEquals($expected, $actual->key());
    }
}
