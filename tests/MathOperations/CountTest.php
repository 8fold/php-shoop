<?php

namespace Eightfold\Shoop\Tests\MathOperations;

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
 * The `string()` method converts the 8fold type to an `ESString` type.
 *
 * Typpically uses PHP's `print_r()` after using `unfold()` on the value.
 *
 * This allows each Shoop type to be treated as a PHP `string`, which means `string()` is an alias for the PHP `__toString()` magic method.
 *
 * @declared Eightfold\Shoop\Interfaces\Shooped
 *
 * @defined Eightfold\Shoop\Traits\ShoopedImp
 *
 * @overridden Eightfold\Shoop\ESBool, Eightfold\Shoop\ESInt, Eightfold\Shoop\ESJson, Eightfold\Shoop\ESString
 *
 * @return Eightfold\Shoop\ESString
 */
class CountTest extends TestCase
{
    public function testESArray()
    {
        $expected = 2;
        $actual = ESArray::fold([])->plus("hello", "goodbye")->count();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @not
     */
    public function testESBool()
    {
        $this->assertFalse(false);
    }

    public function testESDictionary()
    {
        $expected = 2;
        $actual = ESDictionary::fold([])->plus("value", "key", "value2", "key2")->count();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESInt()
    {
        $expected = 5;
        $actual = ESInt::fold(5)->count();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESJson()
    {
        $expected = 1;
        $actual = ESJson::fold('{"member":"value"}')->count();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESObject()
    {
        $object = new \stdClass();
        $object->member = "value";
        $object->member2 = "value2";

        $expected = 2;
        $actual = ESObject::fold($object)->count();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESString()
    {
        $expected = 5;
        $actual = ESString::fold("Hello")->count();
        $this->assertEquals($expected, $actual->unfold());
    }
}
