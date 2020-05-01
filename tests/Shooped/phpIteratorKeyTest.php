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
 * The `Iterator` PHP interface requires the `rewind()` method.
 *
 * The iterator interface mthods allow the object to be used in loops. The `rewind()` method returns position to the first position, when applicable.
 *
 * @declared Eightfold\Shoop\Traits\Shoop
 *
 * @defined Eightfold\Shoop\Interfaces\ShoopedImp
 *
 * @overridden Eightfold\Shoop\ESBool, Eightfold\Shoop\ESInt
 *
 * @return bool
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
