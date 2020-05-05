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

    /**
     * Equivalent to `dictionary()->rewind()`.
     */
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

    /**
     * Equivalent to `array()->rewind()`.
     */
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
