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
    public function testESBool()
    {
        $this->assertFalse(false);
    }

    public function testESDictionary()
    {
        $base = ["key" => "value", "key2" => "value2"];

        $expected = [];
        $actual = ESDictionary::fold($base)->drop("key", "key2");
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
