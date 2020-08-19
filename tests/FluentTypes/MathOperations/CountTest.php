<?php

namespace Eightfold\Shoop\Tests\MathOperations;

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
 * The `count()` method returns the number of values in the ESArray or ESDictionary representation of the `Shooped type`.
 *
 * @return Eightfold\Shoop\ESInteger
 */
class CountTest extends TestCase
{
    public function testESArray()
    {
        $expected = 2;
        $actual = ESArray::fold([])->plus("hello", "goodbye")->count();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @not
     */
    public function testESBoolean()
    {
        $this->assertFalse(false);
    }

    public function testESDictionary()
    {
        $expected = 2;
        $actual = ESDictionary::fold([])->plus("value", "member", "value2", "member2")->count();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESInteger()
    {
        $expected = 5;
        $actual = ESInteger::fold(5)->count();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESJson()
    {
        $expected = 1;
        $actual = ESJson::fold('{"member":"value"}')->count();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESObject()
    {
        $object = new \stdClass();
        $object->member = "value";
        $object->member2 = "value2";

        $expected = 2;
        $actual = ESObject::fold($object)->count();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESString()
    {
        $expected = 5;
        $actual = ESString::fold("Hello")->count();
        $this->assertEquals($expected, $actual->unfold());
    }
}
