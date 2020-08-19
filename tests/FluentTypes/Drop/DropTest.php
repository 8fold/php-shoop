<?php

namespace Eightfold\Shoop\Tests\Drop;

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
 * The `drop()` method removes the value for the given member.
 *
 * @return Eightfold\Shoop\ESArray | Eightfold\Shoop\ESDictionary | Eightfold\Shoop\ESJson | Eightfold\Shoop\ESObject | Eightfold\Shoop\FluentTypes\ESString
 */
class DropTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];

        $expected = ["hello"];
        $actual = Shoop::array($base)->drop(1);
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

        $expected = [];
        $actual = ESDictionary::fold($base)->drop("member", "member2");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @not
     */
    public function testESInt()
    {
        $this->assertFalse(false);
    }

    public function testESJson()
    {
        $base = '{"member":"value", "member2":"value2", "member3":"value3"}';

        $expected = '{"member2":"value2"}';
        $actual = ESJson::fold($base)->drop("member", "member3");
        $this->assertEquals($expected, $actual);
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->testMember = "test";

        $expected = new \stdClass();
        $actual = ESObject::fold($base)->drop("testMember");
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESString()
    {
        $base = "Hello, World!";

        $expected = "Hlo ol!";
        $actual = ESString::fold($base)->drop(1, 3, 5, 7, 9, 11);
        $this->assertEquals($expected, $actual->unfold());
    }
}
