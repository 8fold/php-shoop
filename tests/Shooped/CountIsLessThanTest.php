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
 * @see isGreaterThanOrEqualTo() Uses less than comparison (<) as opposed to greater than or equal to (>=).
 *
 * @return Eightfold\Shoop\ESBool
 */
class CountIsLessThanTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->countIsLessThan(3);
        $this->assertTrue($actual->unfold());

        $actual = ESArray::fold($base)->countIsLessThan(3, function($result, $array) {
            return $array;
        });
        $this->assertTrue(is_a($actual, ESArray::class));
        $this->assertEquals($base, $actual->unfold());
    }

    public function testESBool()
    {
        $base = true;
        $actual = ESBool::fold($base)->countIsLessThan(false);
        $this->assertFalse($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = ["member" => "value"];
        $actual = ESDictionary::fold($base)->countIsLessThan(1);
        $this->assertFalse($actual->unfold());
    }

    public function testESInt()
    {
        $base = 11;
        $actual = ESInt::fold(11)->countIsLessThan(9);
        $this->assertFalse($actual->unfold());
    }

    public function testESJson()
    {
        $base = '{"test":"test"}';
        $actual = ESJson::fold($base)->countIsLessThan(1);
        $this->assertFalse($actual->unfold());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->test = "test";

        $actual = ESObject::fold($base)->countIsLessThan(1);
        $this->assertFalse($actual->unfold());
    }

    public function testESString()
    {
        $actual = ESString::fold("a")->countIsLessThan(3);
        $this->assertTrue($actual->unfold());

        $actual = ESString::fold("b")->countIsLessThan(1);
        $this->assertFalse($actual->unfold());
    }
}
