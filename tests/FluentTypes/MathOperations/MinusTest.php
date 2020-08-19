<?php

namespace Eightfold\Shoop\Tests\MathOperations;

use PHPUnit\Framework\TestCase;



use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    ESBoolean,
    ESDictionary,
    ESInt,
    ESJson,
    ESObject,
    ESString
};

/**
 * The `minus()` method for most `Shoop types` unsets or removes the specified members.
 */
class MinusTest extends TestCase
{
    /**
     * @return Eightfold\Shoop\ESArray With the specified indeces and corresponding values removed and re-indexed.
     */
    public function testESArray()
    {
        $expected = ["goodbye"];
        $actual = ESArray::fold(["hello", "goodbye", "hello"])->minus(0, 2);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @not
     */
    public function testESBoolean()
    {
        $this->assertFalse(false);
    }

    /**
     * @return Eightfold\Shoop\ESDictionary With the specified members and corresponding values removed.
     */
    public function testESDictionary()
    {
        $expected = [];
        $actual = ESDictionary::fold(["member" => "value", "member2" => "value2"])->minus("member", "member2");
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESInt()
    {
        $expected = 2;
        $actual = ESInt::fold(5)->minus(3);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see ESObject->minus()
     */
    public function testESJson()
    {
        $expected = '{"member":"value"}';
        $actual = ESJson::fold('{"member":"value","member2":"value2"}')->minus("member2");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESObject With the specified members and corresponding values removed.
     */
    public function testESObject()
    {
        $expected = new \stdClass();
        $expected->member = "value";

        $actual = new \stdClass();
        $actual->member = "value";
        $actual->member2 = "value2";
        $actual = ESObject::fold($actual)->minus("member2");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\FluentTypes\ESString With the specified letters removed.
     */
    public function testESString()
    {
        $expected = "He, rd";
        $actual = ESString::fold("Hello, World!")->minus("W", "l", "o", "!");
        $this->assertEquals($expected, $actual->unfold());
    }
}
