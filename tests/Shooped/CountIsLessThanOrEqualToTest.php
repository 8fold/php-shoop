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
 * The `countIsLessThanOrEqualTo()` method converts the Shoop type using the `count()` method (using the PHP Countable interface) and uses the result to compare the given value to. The result ESBool and closure, if available, is then passed to the `isLessThanOrEqualTo()` method.
 *
 * Note: Expects both values to be of the same type, Shoop type, or combination (cannot compare an `int` to a `bool`, for example).
 *
 * @return Eightfold\Shoop\ESBool
 */
class CountIsLessThanOrEqualToTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->countIsLessThanOrEqualTo(2);
        $this->assertTrue($actual->unfold());

        $actual = ESArray::fold($base)->countIsLessThanOrEqualTo(2, function($result, $array) {
            return $array;
        });
        $this->assertTrue(is_a($actual, ESArray::class));
        $this->assertEquals($base, $actual->unfold());
    }

    public function testESBool()
    {
        $base = true;
        $actual = ESBool::fold($base)->countIsLessThanOrEqualTo(false);
        $this->assertFalse($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = ["member" => "value"];
        $actual = ESDictionary::fold($base)->countIsLessThanOrEqualTo(3);
        $this->assertTrue($actual->unfold());
    }

    public function testESInt()
    {
        $base = 11;
        $actual = ESInt::fold(11)->countIsLessThanOrEqualTo(12);
        $this->assertTrue($actual->unfold());
    }

    public function testESJson()
    {
        $base = '{"test":"test"}';
        $actual = ESJson::fold($base)->countIsLessThanOrEqualTo(3);
        $this->assertTrue($actual->unfold());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->test = "test";

        $actual = ESObject::fold($base)->countIsLessThanOrEqualTo(100);
        $this->assertTrue($actual->unfold());
    }

    public function testESString()
    {
        $actual = ESString::fold("a")->countIsLessThanOrEqualTo(4);
        $this->assertTrue($actual->unfold());

        $actual = ESString::fold("b")->countIsLessThanOrEqualTo(1);
        $this->assertTrue($actual->unfold());
    }
}
