<?php

namespace Eightfold\Shoop\Tests\Foldable;

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

    public function testESBoolean()
    {
        $expected = true;
        $actual = new ESBoolean(true);
        $this->assertEquals($expected, $actual->unfold());

        $actual = ESBoolean::fold(true);
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

    public function testESInteger()
    {
        $expected = 1;
        $actual = new ESInteger($expected);
        $this->assertEquals($expected, $actual->unfold());

        $actual = ESInteger::fold($expected);
        $this->assertEquals($expected, $actual->unfold());

        $expected = 1;
        $actual = ESInteger::fold(1.1);
        $this->assertEquals($expected, $actual->unfold());

        $expected = 0;
        $actual = ESInteger::fold("hello");
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

    public function testESTuple()
    {
        $expected = new \stdClass();
        $actual = new ESTuple($expected);
        $this->assertEquals($expected, $actual->unfold());

        $actual = ESTuple::fold($expected);
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
