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
 * The `isLessThan()` method uses less than comparison (<) as opposed to greater than (>).
 *
 * @return Eightfold\Shoop\ESBoolean
 */
class IsLessThanTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->isLessThan($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESBoolean()
    {
        $base = true;
        $actual = ESBoolean::fold($base)->isLessThan(false);
        $this->assertFalse($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = ["member" => "value"];
        $actual = ESDictionary::fold($base)->isLessThan($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESInteger()
    {
        $base = 11;
        $actual = ESInteger::fold(11)->isLessThan($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESJson()
    {
        $base = '{"test":"test"}';
        $actual = ESJson::fold($base)->isLessThan($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESTuple()
    {
        $base = new \stdClass();
        $base->test = "test";

        $actual = ESTuple::fold($base)->isLessThan($base);
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
