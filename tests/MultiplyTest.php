<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    Type,
    ESArray,
    ESBool,
    ESDictionary,
    ESInt,
    ESJson,
    ESObject,
    ESString
};

/**
 * The `multiply()` takes the given value and rationally replicates it.
 *
 * Typically a Shoop array is returned with the same number of values as the multiplier supplied.
 *
 * @declared Eightfold\Shoop\Interfaces\Shooped
 *
 * @defined Eightfold\Shoop\Traits\ShoopedImp
 *
 * @overridden Eightfold\Shoop\ESInt, Eightfold\Shoop\ESString
 *
 * @return Eightfold\Shoop\ESArray, Eightfold\Shoop\ESInt, Eightfold\Shoop\ESString
 */
class MultiplyTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $expected = [
            $base,
            $base,
            $base
        ];

        $actual = ESArray::fold($base)->multiply(3);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESBool()
    {
        $base = true;
        $expected = [$base, $base, $base, $base];

        $actual = ESBool::fold($base)->multiply(4);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESDictionary()
    {
        $base = ["key" => "value"];
        $expected = [$base, $base, $base, $base, $base];

        $actual = ESDictionary::fold($base)->multiply(5);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * Returns the product of the value by the multiplier.
     */
    public function testESInt()
    {
        $expected = 10;

        $actual = ESInt::fold(2)->multiply(5);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESJson()
    {
        $base = '{"test":"test"}';
        $expected = [
            $base
        ];

        $actual = ESJson::fold($base)->multiply(1);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $expected = [
            $base,
            $base,
            $base,
            $base,
            $base,
            $base,
            $base,
            $base,
            $base
        ];

        $actual = ESObject::fold($base)->multiply(9);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * Uses PHP `str_repeat()` to create a new ESString.
     */
    public function testESString()
    {
        $base = "a";
        $expected = "{$base}{$base}{$base}{$base}";

        $actual = ESString::fold($base)->multiply(4);
        $this->assertEquals($expected, $actual->unfold());
    }
}
