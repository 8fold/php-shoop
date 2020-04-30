<?php

namespace Eightfold\Shoop\Tests\ComparisonOperators;

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
 * The `isGreaterThan()` performs PHP greater than comparison (>) to determine if the initial value is greater than the compared value.
 *
 * Note: Expects both values to be of the same type, Shoop type, or combination (cannot compare an `int` to a `bool`, for example).
 *
 * @declared Eightfold\Shoop\Interfaces\Compare
 *
 * @defined Eightfold\Shoop\Traits\CompareImp
 *
 * @overridden
 *
 * @return Eightfold\Shoop\ESBool
 */
class ShuffleTest extends TestCase
{
    public function testESArray()
    {
        $this->assertTrue(true);
    }

    /**
     * @not Could be a random bolean generator
     */
    public function testESBool()
    {
        $this->assertFalse(false);
    }

    /**
     * @not Has direct access
     */
    public function testESDictionary()
    {
        $this->assertFalse(false);
    }

    /**
     * @not Could shuffle the range
     */
    public function testESInt()
    {
        $this->assertFalse(false);
    }

    /**
     * @not Has direct access
     */
    public function testESJson()
    {
        $this->assertFalse(false);
    }

    /**
     * @not Has direct access
     */
    public function testESObject()
    {
        $this->assertFalse(false);
    }

    public function testESString()
    {
        $actual = ESString::fold("a")->has("b");
        $this->assertFalse($actual->unfold());

        $actual = ESString::fold("b")->has("b");
        $this->assertTrue($actual->unfold());
    }
}
