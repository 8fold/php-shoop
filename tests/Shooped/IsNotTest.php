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
 * The `isNot()` returns the opposite of calling `is()`.
 *
 * @declared Eightfold\Shoop\Interfaces\Shooped
 *
 * @defined Eightfold\Shoop\Traits\ShoopedImp
 *
 * @overridden
 *
 * @return Eightfold\Shoop\ESBool
 */
class IsNotTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESBool()
    {
        $base = true;
        $actual = ESBool::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = ["key" => "value"];
        $actual = ESDictionary::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }

    /**
     * Returns the product of the value by the multiplier.
     */
    public function testESInt()
    {
        $base = 10;
        $actual = ESInt::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESJson()
    {
        $base = '{"test":"test"}';
        $actual = ESJson::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->test = "test";
        $actual = ESObject::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }

    /**
     * Uses PHP `str_repeat()` to create a new ESString.
     */
    public function testESString()
    {
        $base = "alphabet soup";
        $actual = ESString::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }
}