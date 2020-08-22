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
 * The `plus()` method in most cases appends the given value to the original value.
 */
class PlusTest extends TestCase
{
    /**
     * @return Eightfold\Shoop\ESArray After adding values to the end of the array.
     */
    public function ESArray()
    {
        $expected = ["hello", "goodbye"];
        $actual = ESArray::fold([])->plus("hello", "goodbye");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @not
     */
    public function ESBoolean()
    {
        $this->assertFalse(false);
    }

    /**
     * @return Eightfold\Shoop\ESDictionary After adding the value-member pairs to the end of the original ESDictionary.
     */
    public function ESDictionary()
    {
        $expected = ["member" => "value", "member2" => "value2"];
        $actual = ESDictionary::fold([])->plus("value", "member", "value2", "member2");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESInteger After mathematically adding the original value to the given value.
     */
    public function ESInteger()
    {
        $expected = 8;
        $actual = ESInteger::fold(5)->plus(3);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see ESTuple->plus()
     *
     * @return Eightfold\Shoop\ESJso
     */
    public function ESJson()
    {
        $expected = '{"member":"value","member2":"value2"}';
        $actual = ESJson::fold('{"member":"value"}')->plus("value2", "member2");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESTuple After adding the value-member pairs to the object.
     */
    public function ESTuple()
    {
        $expected = new \stdClass();
        $expected->member = "value";
        $expected->member2 = "value2";
        $actual = ESTuple::fold(new \stdClass())->plus("value", "member", "value2", "member2");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\FluentTypes\ESString After appending the original string with the values.
     */
    public function ESString()
    {
        $expected = "Hello, World!";
        $actual = ESString::fold("Hello")->plus(", ", "World", "!");
        $this->assertEquals($expected, $actual->unfold());
    }
}
