<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\ESInt;

class IntTest extends TestCase
{
    public function testCanInitialize()
    {
        $result = ESInt::init(5);
        $this->assertNotNull($result);
        $this->assertEquals(5, $result->int());

        $this->assertEquals("5", $result->description());
    }

    public function testCanDoDistanceAndAdvance()
    {
        $result = ESInt::init(5)->distance(20)->int();
        $this->assertEquals(15, $result);

        $result = ESInt::init(20)->distance(5)->int();
        $this->assertEquals(-15, $result);

        $result = ESInt::init(20)->advanced(5)->int();
        $this->assertEquals(25, $result);

        $result = ESInt::init(20)->advanced(-5)->int();
        $this->assertEquals(15, $result);
    }

    public function testCanAcceptFloatAndDouble()
    {
        $float = ESInt::fromFloat(5.9);
        $this->assertEquals(5, $float->int());

        $double = ESInt::fromDouble(5.8888888888888);
        $this->assertEquals(5, $double->int());        
    }

    public function testInitialFromString()
    {
        $result = ESInt::fromString("500");
        $this->assertEquals(500, $result->int());
    }

    public function testCanNegateValue()
    {
        $result = ESInt::init(500)->negate()->int();
        $this->assertEquals(-500, $result);
    }
}
