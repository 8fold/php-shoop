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
    ESObject,
    ESString
};

/**
 * @group CountIsGreaterThan
 *
 * The `countIsGreaterThan()` method converts the Shoop type using the `count()` method (using the PHP Countable interface) and uses the result to compare the given value to. The result ESBoolean and closure, if available, is then passed to the `isGreaterThan()` method.
 *
 * Note: Expects both values to be of the same type, Shoop type, or combination (cannot compare an `int` to a `bool`, for example).
 *
 * @return Eightfold\Shoop\ESBoolean
 */
class CountIsGreaterThanTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->countIsGreaterThan(2);
        $this->assertFalse($actual->unfold());
    }

    public function testESBoolean()
    {
        $base = true;
        $actual = ESBoolean::fold($base)->countIsGreaterThan(0);
        $this->assertTrue($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = ["member" => "value"];
        $actual = ESDictionary::fold($base)->countIsGreaterThan(1);
        $this->assertFalse($actual->unfold());
    }

    public function testESInteger()
    {
        $base = 10;
        $actual = ESInteger::fold(11)->countIsGreaterThan($base);
        $this->assertTrue($actual->unfold());

        $actual = ESInteger::fold(9)->countIsGreaterThan($base);
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
