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
    ESObject,
    ESString
};

/**
 * The `offsetExists()` method is part of the `ArrayAccess` interface and checks if the value has the specified member.
 *
 * Most implementations are based on the array representation of the `Shoop type`.
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

    public function testESBoolean()
    {
        $actual = ESBoolean::fold(true)->offsetExists("true");
        $this->assertTrue($actual);

        $actual = ESBoolean::fold(true)->offsetExists("false");
        $this->assertTrue($actual);
    }

    public function testESDictionary()
    {
        $actual = ESDictionary::fold(["member" => false])->offsetExists("member");
        $this->assertTrue($actual);
    }

    public function testESInteger()
    {
        $actual = ESInteger::fold(10)->offsetExists(8);
        $this->assertTrue($actual);

        $actual = ESInteger::fold(10)->offsetExists(9);
        $this->assertTrue($actual);

        $actual = ESInteger::fold(10)->offsetExists(11);
        $this->assertFalse($actual);
    }

    public function testESJson()
    {
        $actual = ESJson::fold('{"test":true}')->offsetExists("test");
        $this->assertTrue($actual);
    }

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
