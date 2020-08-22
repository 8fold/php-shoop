<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;



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
 * The `offsetGet()` method is part of the `ArrayAccess` interface and retrieves the value of the specified member.
 *
 * Most implementations are based on the array representation of the Shoop type.
 *
 * @return bool
 */
class OffsetGetTest extends TestCase
{
    public function ESArray()
    {
        $actual = ESArray::fold([false, true])->offsetGet(0);
        $this->assertFalse($actual);
    }

    /**
     * Equivalent to calling `unfold()` regardless of argument value.
     */
    public function ESBoolean()
    {
        $actual = ESBoolean::fold(true)->offsetGet("true");
        $this->assertTrue($actual);
    }

    public function ESDictionary()
    {
        $actual = ESDictionary::fold(["member" => false])->offsetGet("member");
        $this->assertFalse($actual);
    }

    public function ESInteger()
    {
        $actual = ESInteger::fold(10)->offsetGet(8);
        $this->assertEquals(8, $actual);

        $actual = ESInteger::fold(10)->offsetGet(9);
        $this->assertEquals(9, $actual);
    }

    public function ESJson()
    {
        $actual = ESJson::fold('{"test":true}')->offsetGet("test");
        $this->assertTrue($actual);
    }

    public function ESTuple()
    {
        $base = new \stdClass();
        $base->test = false;

        $actual = ESTuple::fold($base)->offsetGet("test");
        $this->assertFalse($actual);
    }

    public function ESString()
    {
        $actual = ESString::fold("alphabet soup")->offsetGet(10);
        $this->assertEquals("o", $actual);
    }
}
