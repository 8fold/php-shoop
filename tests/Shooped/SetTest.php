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
 * The `is()` performs PHP identical comparison (===) to determine if the initial value is the same as the compared value.
 *
 * @declared Eightfold\Shoop\Interfaces\Shooped
 *
 * @defined Eightfold\Shoop\Traits\ShoopedImp
 *
 * @overridden
 *
 * @return Eightfold\Shoop\ESBool
 */
class SetTest extends TestCase
{
    public function testESArray()
    {
        $expected = ["hello", "world"];
        $actual = ESArray::fold(["hello", "Shoop"])->set("world", 1);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESBool()
    {
        $base = true;
        $actual = ESBool::fold($base)->set(false);
        $this->assertFalse($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = ["key" => "value"];

        $expected = ["key" => "value", "key2" => "value2"];
        $actual = ESDictionary::fold($base)->set("value2", "key2");
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESInt()
    {
        $base = 10;

        $expected = 12;
        $actual = ESInt::fold($base)->set(12);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESJson()
    {
        $base = '{}';

        $expected = '{"test":"test"}';
        $actual = ESJson::fold($base)->set("test", "test");
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESObject()
    {
        $expected = new \stdClass();
        $expected->test = "test";
        $actual = ESObject::fold(new \stdClass())->set("test", "test");
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESString()
    {
        $base = "alphabet soup";

        $expected = "hello";
        $actual = ESString::fold($base)->set($expected);
        $this->assertEquals($expected, $actual->unfold());
    }
}
