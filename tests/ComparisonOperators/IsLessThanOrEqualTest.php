<?php

namespace Eightfold\Shoop\Tests\ComparisonOperators;

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
 * @see isGreaterThanOrEqualTo() Uses less than or equal to comparison (<=) as opposed to greater than or equal to (>=).
 *
 * @return Eightfold\Shoop\ESBool
 */
class IsLessThanOrEqualTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->isLessThanOrEqual($base);
        $this->assertTrue($actual->unfold());
    }

    public function testESBool()
    {
        $base = true;
        $actual = ESBool::fold($base)->isLessThanOrEqual(false);
        $this->assertFalse($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = ["key" => "value"];
        $actual = ESDictionary::fold($base)->isLessThanOrEqual($base);
        $this->assertTrue($actual->unfold());
    }

    public function testESInt()
    {
        $base = 11;
        $actual = ESInt::fold(11)->isLessThanOrEqual($base);
        $this->assertTrue($actual->unfold());
    }

    public function testESJson()
    {
        $base = '{"test":"test"}';
        $actual = ESJson::fold($base)->isLessThanOrEqual($base);
        $this->assertTrue($actual->unfold());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->test = "test";

        $actual = ESObject::fold($base)->isLessThanOrEqual($base);
        $this->assertTrue($actual->unfold());
    }

    public function testESString()
    {
        $actual = ESString::fold("a")->isLessThanOrEqual("b");
        $this->assertTrue($actual->unfold());

        $actual = ESString::fold("b")->isLessThanOrEqual("b");
        $this->assertTrue($actual->unfold());
    }
}
