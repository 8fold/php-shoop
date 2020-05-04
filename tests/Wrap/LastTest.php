<?php

namespace Eightfold\Shoop\Tests\Wrap;

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
class LastTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];

        $expected = "world";
        $actual = Shoop::array($base)->last();
        $this->assertEquals(ESString::class, get_class($actual));
        $this->assertEquals($expected, $actual);
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
        $base = ["first" => 1, "second" => 2];

        $expected = 2;
        $actual = ESDictionary::fold($base)->last();
        $this->assertEquals(ESInt::class, get_class($actual));
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

        $expected = "value3";
        $actual = ESJson::fold($base)->last();
        $this->assertEquals(ESString::class, get_class($actual));
        $this->assertEquals($expected, $actual);
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->testMember = new \stdClass();
        $base->testMember2 = 2;

        $expected = 2;
        $actual = ESObject::fold($base)->last();
        $this->assertEquals(ESInt::class, get_class($actual));
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESString()
    {
        $expected = "!";
        $actual = Shoop::string("Hello, World!")->last();
        $this->assertEquals(ESString::class, get_class($actual));
        $this->assertEquals($expected, $actual);
    }
}
