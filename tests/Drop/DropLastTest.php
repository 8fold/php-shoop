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
    public function testESBool()
    {
        $this->assertFalse(false);
    }

    public function testESDictionary()
    {
        $base = ["key" => "value", "key2" => "value2"];

        $expected = ["key" => "value"];
        $actual = ESDictionary::fold($base)->dropLast();
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
