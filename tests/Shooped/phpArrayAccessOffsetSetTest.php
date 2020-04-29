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
 * The `ArrayAccess` PHP interface requires the `offsetSet()` method, which allows you to interact with the object using array notation with something like `$array[] = $value`.
 *
 * If the `offset` already exists, the `value` will always be overwritten.
 *
 * @declared Eightfold\Shoop\Traits\Shoop
 *
 * @defined Eightfold\Shoop\Interfaces\ShoopedImp
 *
 * @overridden Eightfold\Shoop\ESBool, Eightfold\Shoop\ESInt, Eightfold\Shoop\ESJson, Eightfold\Shoop\ESObject
 *
 * @return bool
 */
class OffsetSetTest extends TestCase
{
    public function testESArray()
    {
        $actual = ESArray::fold([false, true]);
        $actual->offsetSet(0, true);
        $this->assertTrue($actual->getUnfolded(0));
    }

    /**
     * Changes current `value` to the given `value`, not a new instance.
     */
    public function testESBool()
    {
        $actual = ESBool::fold(true);
        $actual->offsetSet(0, false);
        $this->assertFalse($actual->unfold());
    }

    public function testESDictionary()
    {
        $actual = ESDictionary::fold(["key" => false]);
        $actual->offsetSet("key", true);
        $this->assertTrue($actual->getUnfolded("key"));
    }

    /**
     * Changes current `value` to the given `value`, not a new instance.
     */
    public function testESInt()
    {
        $actual = ESInt::fold(10);
        $actual->offsetSet(0, 8);
        $this->assertEquals(8, $actual->unfold());
    }

    /**
     * Equivalent to calling `object()->offsetSet()->json()` on the ESJson.
     */
    public function testESJson()
    {
        $expected = '{"test":false}';
        $actual = ESJson::fold('{"test":true}');
        $actual->offsetSet("test", false);
        $this->assertEquals($expected, $actual->stringUnfolded());
    }

    /**
     * Uses object notation ($o->{}) instead of array notation ($o->[]) to update value.
     */
    public function testESObject()
    {
        $base = new \stdClass();
        $base->test = false;

        $actual = ESObject::fold($base);
        $actual->offsetSet("test", true);
        $this->assertTrue($actual->getUnfolded("test"));
    }

    public function testESString()
    {
        $expected = "coop";
        $actual = ESString::fold("comp");
        $actual->offsetSet(2, "o");
        $this->assertEquals($expected, $actual);
    }
}
