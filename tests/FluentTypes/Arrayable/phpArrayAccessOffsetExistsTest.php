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
 * The `offsetExists()` method is part of the `ArrayAccess` interface and checks if the value has the specified member.
 *
 * Most implementations are based on the array representation of the `Shoop type`.
 *
 * @return bool
 */
class OffsetExistsTest extends TestCase
{
    public function ESArray()
    {
        $actual = ESArray::fold([false, true])->offsetExists(1);
        $this->assertTrue($actual);
    }

    public function ESBoolean()
    {
        $actual = ESBoolean::fold(true)->offsetExists("true");
        $this->assertTrue($actual);

        $actual = ESBoolean::fold(true)->offsetExists("false");
        $this->assertTrue($actual);
    }

    public function ESDictionary()
    {
        $actual = ESDictionary::fold(["member" => false])->offsetExists("member");
        $this->assertTrue($actual);
    }

    public function ESInteger()
    {
        $actual = ESInteger::fold(10)->offsetExists(8);
        $this->assertTrue($actual);

        $actual = ESInteger::fold(10)->offsetExists(9);
        $this->assertTrue($actual);

        $actual = ESInteger::fold(10)->offsetExists(11);
        $this->assertFalse($actual);
    }

    public function ESJson()
    {
        $actual = ESJson::fold('{"test":true}')->offsetExists("test");
        $this->assertTrue($actual);
    }

    public function ESTuple()
    {
        $base = new \stdClass();
        $base->test = false;

        $actual = ESTuple::fold($base)->offsetExists("test");
        $this->assertTrue($actual);
    }

    public function ESString()
    {
        $actual = ESString::fold("alphabet soup")->offsetExists(10);
        $this->assertTrue($actual);
    }
}
