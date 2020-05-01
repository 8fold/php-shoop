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
 * The `is()` performs PHP identical comparison (===) to determine if the initial value is the same as the compared value.
 *
 * @declared Eightfold\Shoop\Interfaces\Shooped
 *
 * @defined Eightfold\Shoop\Traits\ShoopedImp
 *
 * @overridden
 *
 * @return Eightfold\Shoop\ESBool
 */
class IsTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->is($base);
        $this->assertTrue($actual->unfold());
    }

    public function testESBool()
    {
        $base = true;
        $actual = ESBool::fold($base)->is($base);
        $this->assertTrue($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = ["key" => "value"];
        $actual = ESDictionary::fold($base)->is($base);
        $this->assertTrue($actual->unfold());
    }

    /**
     * Returns the product of the value by the multiplier.
     */
    public function testESInt()
    {
        $base = 10;
        $actual = ESInt::fold($base)->is($base);
        $this->assertTrue($actual->unfold());
    }

    public function testESJson()
    {
        $base = '{"test":"test"}';
        $actual = ESJson::fold($base)->is($base);
        $this->assertTrue($actual->unfold());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->test = "test";
        $actual = ESObject::fold($base)->is($base);
        $this->assertTrue($actual->unfold());
    }

    /**
     * Uses PHP `str_repeat()` to create a new ESString.
     */
    public function testESString()
    {
        $base = "alphabet soup";
        $actual = ESString::fold($base)->is($base);
        $this->assertTrue($actual->unfold());
    }
}
