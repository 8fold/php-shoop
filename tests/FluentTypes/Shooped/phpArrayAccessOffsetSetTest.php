<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;



use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    ESBoolean,
    ESDictionary,
    ESInt,
    ESJson,
    ESObject,
    ESString
};

/**
 * The `offsetSet()` method is part of the `ArrayAccess` interface and updates (or inserts) the value of the specified member.
 *
 * Most implementations are based on the array representation of the Shoop type.
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
    public function testESBoolean()
    {
        $actual = ESBoolean::fold(true);
        $actual->offsetSet(0, false);
        $this->assertFalse($actual->unfold());
    }

    public function testESDictionary()
    {
        $actual = ESDictionary::fold(["member" => false]);
        $actual->offsetSet("member", true);
        $this->assertTrue($actual->getUnfolded("member"));
    }

    public function testESInt()
    {
        $actual = ESInt::fold(10);
        $actual->offsetSet(0, 8);
        $this->assertEquals(8, $actual->unfold());
    }

    public function testESJson()
    {
        $expected = '{"test":false}';
        $actual = ESJson::fold('{"test":true}');
        $actual->offsetSet("test", false);
        $this->assertEquals($expected, $actual->stringUnfolded());
    }

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
