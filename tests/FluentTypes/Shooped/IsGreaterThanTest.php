<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;



use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    ESBool,
    ESDictionary,
    ESInt,
    ESJson,
    ESObject,
    ESString
};

/**
 * @see isGreaterThan() Uses greater than comparison (>) as opposed to less than (<).
 *
 * @return Eightfold\Shoop\ESBool
 */
class IsGreaterThanTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->isGreaterThan($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESBool()
    {
        $base = true;
        $actual = ESBool::fold($base)->isGreaterThan(false);
        $this->assertTrue($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = ["member" => "value"];
        $actual = ESDictionary::fold($base)->isGreaterThan($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESInt()
    {
        $base = 10;
        $actual = ESInt::fold(11)->isGreaterThan($base);
        $this->assertTrue($actual->unfold());

        $actual = ESInt::fold(9)->isGreaterThan($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESJson()
    {
        $base = '{"test":"test"}';
        $actual = ESJson::fold($base)->isGreaterThan($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->test = "test";

        $actual = ESObject::fold($base)->isGreaterThan($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESString()
    {
        $actual = ESString::fold("a")->isGreaterThan("b");
        $this->assertFalse($actual->unfold());

        $actual = ESString::fold("b")->isGreaterThan("b");
        $this->assertFalse($actual->unfold());
    }
}
