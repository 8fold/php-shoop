<?php

namespace Eightfold\Shoop\Tests\MathOperations;

use PHPUnit\Framework\TestCase;



use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    ESBool,
    ESDictionary,
    ESInt,
    ESJson,
    ESObject,
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
    public function testESArray()
    {
        $expected = ["hello", "goodbye"];
        $actual = ESArray::fold([])->plus("hello", "goodbye");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @not
     */
    public function testESBool()
    {
        $this->assertFalse(false);
    }

    /**
     * @return Eightfold\Shoop\ESDictionary After adding the value-member pairs to the end of the original ESDictionary.
     */
    public function testESDictionary()
    {
        $expected = ["member" => "value", "member2" => "value2"];
        $actual = ESDictionary::fold([])->plus("value", "member", "value2", "member2");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESInt After mathematically adding the original value to the given value.
     */
    public function testESInt()
    {
        $expected = 8;
        $actual = ESInt::fold(5)->plus(3);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see ESObject->plus()
     *
     * @return Eightfold\Shoop\ESJso
     */
    public function testESJson()
    {
        $expected = '{"member":"value","member2":"value2"}';
        $actual = ESJson::fold('{"member":"value"}')->plus("value2", "member2");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESObject After adding the value-member pairs to the object.
     */
    public function testESObject()
    {
        $expected = new \stdClass();
        $expected->member = "value";
        $expected->member2 = "value2";
        $actual = ESObject::fold(new \stdClass())->plus("value", "member", "value2", "member2");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\FluentTypes\ESString After appending the original string with the values.
     */
    public function testESString()
    {
        $expected = "Hello, World!";
        $actual = ESString::fold("Hello")->plus(", ", "World", "!");
        $this->assertEquals($expected, $actual->unfold());
    }
}
