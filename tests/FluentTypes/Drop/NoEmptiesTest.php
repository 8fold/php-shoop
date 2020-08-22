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
 * The `noEmpties()` method checks the values of all members of the object, checks them using the `empty()` function from the PHP standard library and removes any empty values from the object.
 *
 * @return Eightfold\Shoop\ESArray | Eightfold\Shoop\ESDictionary | Eightfold\Shoop\ESJson | Eightfold\Shoop\ESTuple | Eightfold\Shoop\FluentTypes\ESString
 */
class NoEmptiesTest extends TestCase
{
    public function testESArray()
    {
        $base = [0, null];

        $expected = [];
        $actual = Shoop::array($base)->noEmpties();
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
        $base = ["member" => false, "member2" => "value2"];

        $expected = ["member2" => "value2"];
        $actual = ESDictionary::fold($base)->noEmpties();
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
        $base = '{"member":false, "member2":"value2", "member3":0}';

        $expected = '{"member2":"value2"}';
        $actual = ESJson::fold($base)->noEmpties();
        $this->assertEquals($expected, $actual);
    }

    public function testESTuple()
    {
        $base = new \stdClass();
        $base->testMember = "test";

        $expected = new \stdClass();
        $expected->testMember = "test";

        $actual = ESTuple::fold($base)->noEmpties();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESString()
    {
        $base = "Hell0, W0rld!";

        $expected = "Hell,Wrld!";
        $actual = ESString::fold($base)->noEmpties();
        $this->assertEquals($expected, $actual->unfold());
    }
}
