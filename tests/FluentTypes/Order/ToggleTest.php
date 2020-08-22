<?php

namespace Eightfold\Shoop\Tests\Order;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Type;

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
 * The `toggle()` method in most cases reverses the original order of the atomic units of the original value.
 */
class ToggleTest extends TestCase
{
    /**
     * @return Eightfold\Shoop\ESArray After reversing the order of the value index-value pairs.
     */
    public function ESArray()
    {
        $expected = [4 => 5, 3 => 6, 2 => 2, 1 => 1, 0 => 10];
        $actual = Shoop::array([10, 1, 2, 6, 5])->toggle();
        $this->assertEquals($expected, $actual->unfold());

        $expected = [5, 6, 2, 1, 10];
        $actual = Shoop::array([10, 1, 2, 6, 5])->toggle(false);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESBoolean True becomes false, and false becomes true.
     */
    public function ESBoolean()
    {
        $actual = Shoop::bool(true)->toggle();
        $this->assertFalse($actual->unfold());
    }

    /**
     * @see ESArray->toggle()
     *
     * @return Eightfold\Shoop\ESDictionary
     */
    public function ESDictionary()
    {
        $expected = ["hello" => "world", "world" => "hello"];
        $actual = Shoop::dictionary(["world" => "hello", "hello" => "world"])->toggle();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESInteger After multiplying the original value by negative one (-1).
     */
    public function ESInteger()
    {
        $expected = 1;
        $actual = Shoop::integer(-1)->toggle();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see ESOjbect->toggle()
     *
     * @return Eightfold\Shoop\ESJson
     */
    public function ESJson()
    {
        $base = ["beta" => "beta", "alpha2" => "alpha2", "alpha" => "alpha"];
        $expected = json_encode($base);
        $actual = Shoop::json('{"alpha":"alpha", "alpha2":"alpha2", "beta":"beta"}')->toggle();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see ESDictionary->toggle()
     *
     * @return Eightfold\Shoop\ESTuple
     */
    public function ESTuple()
    {
        $expected = ["beta" => "beta", "alpha2" => "alpha2", "alpha" => "alpha"];

        $object = new \stdClass();
        $object->alpha = "alpha";
        $object->alpha2 = "alpha2";
        $object->beta = "beta";

        $actual = Shoop::object($object)->toggle();
        $array = (array) $actual->unfold();
        $this->assertEquals($expected, $array);
    }

    /**
     * @return Eightfold\Shoop\FluentTypes\ESString After reversing the order of the individual characters of the original string.
     */
    public function ESString()
    {
        $expected = "Hello!";
        $actual = Shoop::string("!olleH")->toggle();
        $this->assertEquals($expected, $actual->unfold());
    }
}
