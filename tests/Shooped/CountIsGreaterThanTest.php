<?php

namespace Eightfold\Shoop\Tests\Shooped;

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
 * @see isGreaterThanOrEqualTo() Uses greater than comparison (>) as opposed to greater than or equal to (>=).
 *
 * @return Eightfold\Shoop\ESBool
 */
class CountIsGreaterThanTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->countIsGreaterThan(2);
        $this->assertFalse($actual->unfold());
    }

    public function testESBool()
    {
        $base = true;
        $actual = ESBool::fold($base)->countIsGreaterThan(0);
        $this->assertTrue($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = ["member" => "value"];
        $actual = ESDictionary::fold($base)->countIsGreaterThan(1);
        $this->assertFalse($actual->unfold());
    }

    public function testESInt()
    {
        $base = 10;
        $actual = ESInt::fold(11)->countIsGreaterThan($base);
        $this->assertTrue($actual->unfold());

        $actual = ESInt::fold(9)->countIsGreaterThan($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESJson()
    {
        $base = '{"test":"test"}';
        $actual = ESJson::fold($base)->countIsGreaterThan(1);
        $this->assertFalse($actual->unfold());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->test = "test";

        $actual = ESObject::fold($base)->countIsGreaterThan(1);
        $this->assertFalse($actual->unfold());
    }

    public function testESString()
    {
        $actual = ESString::fold("a")->countIsGreaterThan(1);
        $this->assertFalse($actual->unfold());

        $actual = ESString::fold("b")->countIsGreaterThan(1);
        $this->assertFalse($actual->unfold());
    }
}
