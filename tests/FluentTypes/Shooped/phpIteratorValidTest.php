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
 * The `valid()` method from the `Iterator` interface returns whether the current pointer position is valid.
 *
 * @return bool
 */
class InterfaceIteratorValidTest extends TestCase
{
    public function testESArray()
    {
        $expected = 0;
        $array = ESArray::fold(["hello", "goodbye"]);
        $this->assertTrue($array->valid());
        $array->next();
        $this->assertTrue($array->valid());
        $array->next();
        $this->assertFalse($array->valid());
    }

    public function testESBool()
    {
        $actual = ESBool::fold(true);
        $this->assertTrue($actual->valid());
    }

    public function testESDictionary()
    {
        $expected = "two";
        $actual = ESDictionary::fold(["one" => "hello", "two" => "goodbye"]);
        $actual->next();
        $this->assertEquals($expected, $actual->key());
    }

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
