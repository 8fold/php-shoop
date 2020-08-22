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
 * @see isGreaterThan() Uses greater than comparison (>) as opposed to less than (<).
 *
 * @return Eightfold\Shoop\ESBoolean
 */
class IsGreaterThanTest extends TestCase
{
    public function ESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->isGreaterThan($base);
        $this->assertFalse($actual->unfold());
    }

    public function ESBoolean()
    {
        $base = true;
        $actual = ESBoolean::fold($base)->isGreaterThan(false);
        $this->assertTrue($actual->unfold());
    }

    public function ESDictionary()
    {
        $base = ["member" => "value"];
        $actual = ESDictionary::fold($base)->isGreaterThan($base);
        $this->assertFalse($actual->unfold());
    }

    public function ESInteger()
    {
        $base = 10;
        $actual = ESInteger::fold(11)->isGreaterThan($base);
        $this->assertTrue($actual->unfold());

        $actual = ESInteger::fold(9)->isGreaterThan($base);
        $this->assertFalse($actual->unfold());
    }

    public function ESJson()
    {
        $base = '{"test":"test"}';
        $actual = ESJson::fold($base)->isGreaterThan($base);
        $this->assertFalse($actual->unfold());
    }

    public function ESTuple()
    {
        $base = new \stdClass();
        $base->test = "test";

        $actual = ESTuple::fold($base)->isGreaterThan($base);
        $this->assertFalse($actual->unfold());
    }

    public function ESString()
    {
        $actual = ESString::fold("a")->isGreaterThan("b");
        $this->assertFalse($actual->unfold());

        $actual = ESString::fold("b")->isGreaterThan("b");
        $this->assertFalse($actual->unfold());
    }
}
