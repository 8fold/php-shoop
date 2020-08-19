<?php

namespace Eightfold\Shoop\Tests\Drop;

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
 * @see dropFirst() Removes from end, not beginning.
 *
 * @return Eightfold\Shoop\ESArray
 */
class DropLastTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];

        $expected = [];
        $actual = Shoop::array($base)->dropLast(2);
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
        $base = ["member" => "value", "member2" => "value2"];

        $expected = ["member" => "value"];
        $actual = ESDictionary::fold($base)->dropLast();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @not
     */
    public function testESInteger()
    {
        $this->assertFalse(false);
    }

    public function testESJson()
    {
        $base = '{"member":"value", "member2":"value2", "member3":"value3"}';

        $expected = '{"member":"value"}';
        $actual = ESJson::fold($base)->dropLast(2);
        $this->assertEquals($expected, $actual);
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->testMember = "test";

        $expected = new \stdClass();
        $actual = ESObject::fold($base)->dropLast();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESString()
    {
        $base = "Hello, World!";

        $expected = "Hello";
        $actual = ESString::fold($base)->dropLast(8);
        $this->assertEquals($expected, $actual->unfold());
    }
}
