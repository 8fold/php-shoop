<?php

namespace Eightfold\Shoop\Tests\Foldable;

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
 * The `set()` method in most cases sets the value for a specified members.
 */
class SetTest extends TestCase
{
    /**
     * @return Eightfold\Shoop\ESArray After setting the value for the index.
     */
    public function testESArray()
    {
        $expected = ["hello", "world"];
        $actual = ESArray::fold(["hello", "Shoop"])->set("world", 1);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESBool Sets the value of the bool to the given bool.
     */
    public function testESBool()
    {
        $base = true;
        $actual = ESBool::fold($base)->set(false);
        $this->assertFalse($actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESDictionary After setting the value for the given member.
     */
    public function testESDictionary()
    {
        $base = ["member" => "value"];

        $expected = ["member" => "value", "member2" => "value2"];
        $actual = ESDictionary::fold($base)->set("value2", "member2");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESINt Sets the value of the integer to the given integer.
     */
    public function testESInt()
    {
        $base = 10;

        $expected = 12;
        $actual = ESInt::fold($base)->set(12);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESJson Sets the value of the member to the given value.
     */
    public function testESJson()
    {
        $base = '{}';

        $expected = '{"test":"test"}';
        $actual = ESJson::fold($base)->set("test", "test");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESObject Sets the value of the member to the given value.
     */
    public function testESObject()
    {
        $expected = new \stdClass();
        $expected->test = "test";
        $actual = ESObject::fold(new \stdClass())->set("test", "test");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESString Sets the value of the string to the given string.
     */
    public function testESString()
    {
        $base = "alphabet soup";

        $expected = "hello";
        $actual = ESString::fold($base)->set($expected);
        $this->assertEquals($expected, $actual->unfold());
    }
}
