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
    ESTuple,
    ESString
};

/**
 * The `count()` method returns the number of values in the ESArray or ESDictionary representation of the `Shooped type`.
 *
 * @return Eightfold\Shoop\ESInteger
 */
class CountTest extends TestCase
{
    public function ESArray()
    {
        $expected = 2;
        $actual = ESArray::fold([])->plus("hello", "goodbye")->count();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @not
     */
    public function ESBoolean()
    {
        $this->assertFalse(false);
    }

    public function ESDictionary()
    {
        $expected = 2;
        $actual = ESDictionary::fold([])->plus("value", "member", "value2", "member2")->count();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function ESInteger()
    {
        $expected = 5;
        $actual = ESInteger::fold(5)->count();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function ESJson()
    {
        $expected = 1;
        $actual = ESJson::fold('{"member":"value"}')->count();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function ESTuple()
    {
        $object = new \stdClass();
        $object->member = "value";
        $object->member2 = "value2";

        $expected = 2;
        $actual = ESTuple::fold($object)->count();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function ESString()
    {
        $expected = 5;
        $actual = ESString::fold("Hello")->count();
        $this->assertEquals($expected, $actual->unfold());
    }
}
