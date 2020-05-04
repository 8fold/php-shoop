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
 * The `ArrayAccess` PHP interface requires the `offsetGet()` method, which allows you to interact with the object using array notation with something like `isset()`.
 *
 * @example $array = Shoop::array([1, 2, 3]); $array[1]; // returns 2
 *
 * @declared Eightfold\Shoop\Traits\Shoop
 *
 * @defined Eightfold\Shoop\Interfaces\ShoopedImp
 *
 * @overridden Eightfold\Shoop\ESBool, Eightfold\Shoop\ESInt, Eightfold\Shoop\ESJson, Eightfold\Shoop\ESObject
 *
 * @return bool
 */
class OffsetGetTest extends TestCase
{
    public function testESArray()
    {
        $actual = ESArray::fold([false, true])->offsetGet(0);
        $this->assertFalse($actual);
    }

    /**
     * Equivalent to calling `unfold()` regardless of argument value.
     */
    public function testESBool()
    {
        $actual = ESBool::fold(true)->offsetGet("true");
        $this->assertTrue($actual);
    }

    public function testESDictionary()
    {
        $actual = ESDictionary::fold(["key" => false])->offsetGet("key");
        $this->assertFalse($actual);
    }

    /**
     * Equivalent to calling `array()->offsetGet()` on the ESArray.
     */
    public function testESInt()
    {
        $actual = ESInt::fold(10)->offsetGet(8);
        $this->assertEquals(8, $actual);

        $actual = ESInt::fold(10)->offsetGet(9);
        $this->assertEquals(9, $actual);
    }

    /**
     * Equivalent to calling `dictionary()->offsetGet()` on the ESDictionary.
     */
    public function testESJson()
    {
        $actual = ESJson::fold('{"test":true}')->offsetGet("test");
        $this->assertTrue($actual);
    }

    /**
     * Equivalent to calling `dictionary()->offsetGet()` on the ESDictionary.
     */
    public function testESObject()
    {
        $base = new \stdClass();
        $base->test = false;

        $actual = ESObject::fold($base)->offsetGet("test");
        $this->assertFalse($actual);
    }

    public function testESString()
    {
        $actual = ESString::fold("alphabet soup")->offsetGet(10);
        $this->assertEquals("o", $actual);
    }
}
