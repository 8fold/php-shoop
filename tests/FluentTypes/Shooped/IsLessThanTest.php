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
 * The `isLessThan()` method uses less than comparison (<) as opposed to greater than (>).
 *
 * @return Eightfold\Shoop\ESBool
 */
class IsLessThanTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->isLessThan($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESBool()
    {
        $base = true;
        $actual = ESBool::fold($base)->isLessThan(false);
        $this->assertFalse($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = ["member" => "value"];
        $actual = ESDictionary::fold($base)->isLessThan($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESInt()
    {
        $base = 11;
        $actual = ESInt::fold(11)->isLessThan($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESJson()
    {
        $base = '{"test":"test"}';
        $actual = ESJson::fold($base)->isLessThan($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->test = "test";

        $actual = ESObject::fold($base)->isLessThan($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESString()
    {
        $actual = ESString::fold("a")->isLessThan("b");
        $this->assertTrue($actual->unfold());

        $actual = ESString::fold("b")->isLessThan("b");
        $this->assertFalse($actual->unfold());
    }
}
