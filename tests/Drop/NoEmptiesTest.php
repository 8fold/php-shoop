<?php

namespace Eightfold\Shoop\Tests\Drop;

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
 * The `isGreaterThan()` performs PHP greater than comparison (>) to determine if the initial value is greater than the compared value.
 *
 * Note: Expects both values to be of the same type, Shoop type, or combination (cannot compare an `int` to a `bool`, for example).
 *
 * @declared Eightfold\Shoop\Interfaces\Compare
 *
 * @defined Eightfold\Shoop\Traits\CompareImp
 *
 * @overridden
 *
 * @return Eightfold\Shoop\ESBool
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
    public function testESBool()
    {
        $this->assertFalse(false);
    }

    public function testESDictionary()
    {
        $base = ["key" => false, "key2" => "value2"];

        $expected = ["key2" => "value2"];
        $actual = ESDictionary::fold($base)->noEmpties();
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
        $base = '{"member":false, "member2":"value2", "member3":0}';

        $expected = '{"member2":"value2"}';
        $actual = ESJson::fold($base)->noEmpties();
        $this->assertEquals($expected, $actual);
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->testMember = "test";

        $expected = new \stdClass();
        $expected->testMember = "test";

        $actual = ESObject::fold($base)->noEmpties();
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
