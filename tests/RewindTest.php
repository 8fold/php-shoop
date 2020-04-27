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
 * The `ArrayAccess` PHP interface requires the `offsetUnset()` method, which allows you to interact with the object using array notation with something like `unset($array[0])`.
 *
 * @declared Eightfold\Shoop\Traits\Shoop
 *
 * @defined Eightfold\Shoop\Interfaces\ShoopedImp
 *
 * @overridden Eightfold\Shoop\ESBool, Eightfold\Shoop\ESInt, Eightfold\Shoop\ESJson, Eightfold\Shoop\ESObject
 *
 * @return bool
 */
class RewindTest extends TestCase
{
    public function testESArray()
    {
        $this->assertFalse(true);
        $actual = ESArray::fold([false, true]);
        $actual->offsetUnset(0);
        $this->assertTrue($actual->getUnfolded(1));
    }

    /**
     * No changes will be made.
     */
    public function testESBool()
    {
        $actual = ESBool::fold(true);
        $actual->unsetOffset(0);
        $this->assertTrue($actual->unfold());
    }

    public function testESDictionary()
    {
        $actual = ESDictionary::fold(["key" => false]);
        $actual->offsetUnset("key");
        $this->assertFalse($actual->hasMemberUnfolded("key"));
    }

    /**
     * No changes will be made.
     */
    public function testESInt()
    {
        $actual = ESInt::fold(10);
        $actual->offsetUnset(8);
        $this->assertEquals(10, $actual->unfold());
    }

    /**
     * Equivalent to calling `object()->offsetUnset()->json()` on the ESJson.
     */
    public function testESJson()
    {
        $expected = '{}';
        $actual = ESJson::fold('{"test":true}');
        $actual->offsetUnset("test");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * Uses object notation ($o->{}) instead of array notation ($o->[]) to update value.
     */
    public function testESObject()
    {
        $base = new \stdClass();
        $base->test = false;

        $actual = ESObject::fold($base);
        $actual->offsetUnset("test");
        $this->assertFalse($actual->hasMemberUnfolded("test"));
    }

    public function testESString()
    {
        $expected = "cop";
        $actual = ESString::fold("comp");
        $actual->offsetUnset(2);
        $this->assertEquals($expected, $actual);
    }
}
