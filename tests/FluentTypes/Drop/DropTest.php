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
    ESTuple,
    ESString
};
/**
 * The `drop()` method removes the value for the given member.
 *
 * @return Eightfold\Shoop\ESArray | Eightfold\Shoop\ESDictionary | Eightfold\Shoop\ESJson | Eightfold\Shoop\ESTuple | Eightfold\Shoop\FluentTypes\ESString
 */
class DropTest extends TestCase
{
    public function ESArray()
    {
        $base = ["hello", "world"];

        $expected = ["hello"];
        $actual = Shoop::array($base)->drop(1);
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
        $base = ["member" => "value", "member2" => "value2"];

        $expected = [];
        $actual = ESDictionary::fold($base)->drop("member", "member2");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @not
     */
    public function ESInteger()
    {
        $this->assertFalse(false);
    }

    public function ESJson()
    {
        $base = '{"member":"value", "member2":"value2", "member3":"value3"}';

        $expected = '{"member2":"value2"}';
        $actual = ESJson::fold($base)->drop("member", "member3");
        $this->assertEquals($expected, $actual);
    }

    public function ESTuple()
    {
        $base = new \stdClass();
        $base->testMember = "test";

        $expected = new \stdClass();
        $actual = ESTuple::fold($base)->drop("testMember");
        $this->assertEquals($expected, $actual->unfold());
    }

    public function ESString()
    {
        $base = "Hello, World!";

        $expected = "Hlo ol!";
        $actual = ESString::fold($base)->drop(1, 3, 5, 7, 9, 11);
        $this->assertEquals($expected, $actual->unfold());
    }
}
