<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    Type,
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
class IsGreaterThanTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->isGreaterThanOrEqual($base);
        $this->assertTrue($actual->unfold());
    }

    public function testESBool()
    {
        $base = true;
        $actual = ESBool::fold($base)->isGreaterThanOrEqual(false);
        $this->assertTrue($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = ["key" => "value"];
        $actual = ESDictionary::fold($base)->isGreaterThanOrEqual($base);
        $this->assertTrue($actual->unfold());
    }

    public function testESInt()
    {
        $base = 11;
        $actual = ESInt::fold(11)->isGreaterThanOrEqual($base);
        $this->assertTrue($actual->unfold());
    }

    public function testESJson()
    {
        $base = '{"test":"test"}';
        $actual = ESJson::fold($base)->isGreaterThanOrEqual($base);
        $this->assertTrue($actual->unfold());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->test = "test";

        $actual = ESObject::fold($base)->isGreaterThanOrEqual($base);
        $this->assertTrue($actual->unfold());
    }

    public function testESString()
    {
        $actual = ESString::fold("a")->isGreaterThanOrEqual("b");
        $this->assertFalse($actual->unfold());

        $actual = ESString::fold("b")->isGreaterThanOrEqual("b");
        $this->assertTrue($actual->unfold());
    }
}
