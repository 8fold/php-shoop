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
 * The `unfold()` method returns the value of the Shoop type usually as a PHP type.
 */
class UnfoldTest extends TestCase
{
    public function testESArray()
    {
        $expected = ["testing"];
        $actual = new ESArray($expected);
        $this->assertEquals($expected, $actual->unfold());

        $actual = ESArray::fold($expected);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESBool()
    {
        $expected = true;
        $actual = new ESBool(true);
        $this->assertEquals($expected, $actual->unfold());

        $actual = ESBool::fold(true);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESDictionary()
    {
        $expected = ["hello" => "world"];
        $actual = new ESDictionary($expected);
        $this->assertEquals($expected, $actual->unfold());

        $actual = ESDictionary::fold($expected);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESInt()
    {
        $expected = 1;
        $actual = new ESInt($expected);
        $this->assertEquals($expected, $actual->unfold());

        $actual = ESInt::fold($expected);
        $this->assertEquals($expected, $actual->unfold());

        $expected = 1;
        $actual = ESInt::fold(1.1);
        $this->assertEquals($expected, $actual->unfold());

        $expected = 0;
        $actual = ESInt::fold("hello");
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESJson()
    {
        $expected = '{"test":"test"}';
        $actual = new ESJson($expected);
        $this->assertEquals($expected, $actual->unfold());

        $actual = ESJson::fold($expected);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESObject()
    {
        $expected = new \stdClass();
        $actual = new ESObject($expected);
        $this->assertEquals($expected, $actual->unfold());

        $actual = ESObject::fold($expected);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESString()
    {
        $expected = "hello";
        $actual = new ESString($expected);
        $this->assertEquals($expected, $actual->unfold());

        $actual = ESString::fold($expected);
        $this->assertEquals($expected, $actual->unfold());
    }
}
