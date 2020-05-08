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
 * The `isEmpty()` returns whether the value is empty according to PHP `empty()`.
 *
 * @declared Eightfold\Shoop\Interfaces\Shooped
 *
 * @defined Eightfold\Shoop\Traits\ShoopedImp
 *
 * @overridden Eightfold\Shoop\ESJson, Eightfold\Shoop\ESObject
 *
 * @return Eightfold\Shoop\ESBool
 */
class IsNotEmptyTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->isNotEmpty($base);
        $this->assertTrue($actual->unfold());

        $base = [];
        $actual = ESArray::fold($base)->isNotEmpty($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESBool()
    {
        $base = true;
        $actual = ESBool::fold($base)->isNotEmpty();
        $this->assertTrue($actual->unfold());

        $base = false;
        $actual = ESBool::fold($base)->isNotEmpty();
        $this->assertFalse($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = [];
        $actual = ESDictionary::fold($base)->isNotEmpty();
        $this->assertFalse($actual->unfold());
    }

    public function testESInt()
    {
        $base = 0;
        $actual = ESInt::fold($base)->isNotEmpty();
        $this->assertFalse($actual->unfold());

        $base = 10;
        $actual = ESInt::fold($base)->isNotEmpty();
        $this->assertTrue($actual->unfold());
    }

    /**
     * Uses `object()` then checks if the ESObject `isEmpty()` (no members).
     */
    public function testESJson()
    {
        $base = '{}';
        $actual = ESJson::fold($base)->isNotEmpty();
        $this->assertFalse($actual->unfold());

        $base = '{"test":"test"}';
        $actual = ESJson::fold($base)->isNotEmpty();
        $this->assertTrue($actual->unfold());
    }

    /**
     * Uses `dictionary()` then checks if the ESDictionary `isEmpty()`
     */
    public function testESObject()
    {
        $base = new \stdClass();
        $base->test = "test";
        $actual = ESObject::fold($base)->isNotEmpty();
        $this->assertTrue($actual->unfold());
    }

    public function testESString()
    {
        $base = "alphabet soup";
        $actual = ESString::fold($base)->isNotEmpty();
        $this->assertTrue($actual->unfold());

        $base = "";
        $actual = ESString::fold($base)->isNotEmpty();
        $this->assertFalse($actual->unfold());
    }
}
