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
 * The `ArrayAccess` PHP interface requires the `offsetExists()` method, which allows you to interact with the object using array notation with something like `isset()`.
 *
 * @example $array = Shoop::array([1, 2, 3]); isset($array[1]); // returns true
 *
 * @declared Eightfold\Shoop\Traits\Shoop
 *
 * @defined Eightfold\Shoop\Interfaces\ShoopedImp
 *
 * @overridden Eightfold\Shoop\ESBool, Eightfold\Shoop\ESInt, Eightfold\Shoop\ESJson, Eightfold\Shoop\ESObject
 *
 * @return bool
 */
class OffsetExistsTest extends TestCase
{
    public function testESArray()
    {
        $actual = ESArray::fold([false, true])->offsetExists(1);
        $this->assertTrue($actual);
    }

    /**
     * Equivalent to calling `unfold()` regardless of argument value.
     */
    public function testESBool()
    {
        $actual = ESBool::fold(true)->offsetExists(1);
        $this->assertTrue($actual);
    }

    public function testESDictionary()
    {
        $actual = ESDictionary::fold(["key" => false])->offsetExists("key");
        $this->assertTrue($actual);
    }

    /**
     * Equivalent to calling `array()` then checking if resulting range has offset.
     */
    public function testESInt()
    {
        $actual = ESInt::fold(10)->offsetExists(8);
        $this->assertTrue($actual);

        $actual = ESInt::fold(10)->offsetExists(9);
        $this->assertTrue($actual);

        $actual = ESInt::fold(10)->offsetExists(11);
        $this->assertFalse($actual);
    }

    /**
     * Equivalent to calling `dictionary()` then calling `offsetExists()`.
     */
    public function testESJson()
    {
        $actual = ESJson::fold('{"test":true}')->offsetExists("test");
        $this->assertTrue($actual);
    }

    /**
     * Equivalent to calling `dictionary()` then calling `offsetExists()`.
     */
    public function testESObject()
    {
        $base = new \stdClass();
        $base->test = false;

        $actual = ESObject::fold($base)->offsetExists("test");
        $this->assertTrue($actual);
    }

    public function testESString()
    {
        $actual = ESString::fold("alphabet soup")->offsetExists(10);
        $this->assertTrue($actual);
    }
}
