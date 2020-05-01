<?php

namespace Eightfold\Shoop\Tests\Order;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Type;

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
class ToggleTest extends TestCase
{
    public function testESArray()
    {
        $expected = [4 => 5, 3 => 6, 2 => 2, 1 => 1, 0 => 10];
        $actual = Shoop::array([10, 1, 2, 6, 5])->toggle();
        $this->assertEquals($expected, $actual->unfold());

        $expected = [5, 6, 2, 1, 10];
        $actual = Shoop::array([10, 1, 2, 6, 5])->toggle(false);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESBool()
    {
        $actual = Shoop::bool(true)->toggle();
        $this->assertFalse($actual->unfold());
    }

    public function testESDictionary()
    {
        $expected = ["hello" => "world", "world" => "hello"];
        $actual = Shoop::dictionary(["world" => "hello", "hello" => "world"])->toggle();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESInt()
    {
        $expected = 1;
        $actual = Shoop::int(-1)->toggle();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESJson()
    {
        $base = ["beta" => "beta", "alpha2" => "alpha2", "alpha" => "alpha"];
        $expected = json_encode($base);
        $actual = Shoop::json('{"alpha":"alpha", "alpha2":"alpha2", "beta":"beta"}')->toggle();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @not Has direct access
     */
    public function testESObject()
    {
        $this->assertFalse(true);
    }

    public function testESString()
    {
        $this->assertFalse(true);
    }
}
