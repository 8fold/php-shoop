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
 * The `offsetGet()` method is part of the `ArrayAccess interface` from the PHP standard library and retrieves the value of the specified member.
 *
 * Most implementations are based on the array representation of the `Shoop type`.
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

    public function testESInt()
    {
        $actual = ESInt::fold(10)->offsetGet(8);
        $this->assertEquals(8, $actual);

        $actual = ESInt::fold(10)->offsetGet(9);
        $this->assertEquals(9, $actual);
    }

    public function testESJson()
    {
        $actual = ESJson::fold('{"test":true}')->offsetGet("test");
        $this->assertTrue($actual);
    }

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
