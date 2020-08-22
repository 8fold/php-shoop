<?php

namespace Eightfold\Shoop\Tests\Shooped;

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
 * The `isGreaterThanOrEqualTo()` method applies the PHP greater than comparison (>=) using the original value as the left side and the comparison value as the right side.
 *
 * Note: Expects both values to be of the same type, Shoop type, or combination (cannot compare an `int` to a `bool`, for example).
 *
 * @return Eightfold\Shoop\ESBoolean
 */
class IsGreaterThanOrEqualToTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->isGreaterThanOrEqual($base);
        $this->assertTrue($actual->unfold());
    }

    public function testESBoolean()
    {
        $base = true;
        $actual = ESBoolean::fold($base)->isGreaterThanOrEqual(false);
        $this->assertTrue($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = ["member" => "value"];
        $actual = ESDictionary::fold($base)->isGreaterThanOrEqual($base);
        $this->assertTrue($actual->unfold());
    }

    public function testESInteger()
    {
        $base = 11;
        $actual = ESInteger::fold(11)->isGreaterThanOrEqual($base);
        $this->assertTrue($actual->unfold());
    }

    public function testESJson()
    {
        $base = '{"test":"test"}';
        $actual = ESJson::fold($base)->isGreaterThanOrEqual($base);
        $this->assertTrue($actual->unfold());
    }

    public function testESTuple()
    {
        $base = new \stdClass();
        $base->test = "test";

        $actual = ESTuple::fold($base)->isGreaterThanOrEqual($base);
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
