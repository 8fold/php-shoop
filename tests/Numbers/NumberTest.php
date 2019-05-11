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

    public function testCanRuncomparisons()
    {
        $result = ESInt::init(25);
        $compare = ESInt::init(25);
        $this->assertTrue($result->isSameAs($compare)->bool());

        $result = ESInt::init(25);
        $compare = ESInt::init(20);
        $this->assertTrue($result->isNotSameAs($compare)->bool());
    }

    public function testCanAcceptFloatAndDouble()
    {
        $float = ESInt::fromFloat(5.9);
        $this->assertEquals(5, $float->int());

        $double = ESInt::fromDouble(5.8888888888888);
        $this->assertEquals(5, $double->int());
    }

    public function testMultipleOfAndQuotient()
    {
        $result = ESInt::init(25)->isMultipleOf(5)->bool();
        $this->assertTrue($result);

        $result = ESInt::init(25)->isMultipleOf(6)->bool();
        $this->assertFalse($result);

        $result = ESInt::init(25)->quotientAndRemainder(4)->values();
        $this->assertEquals(6, ($result["quotient"])->int());
        $this->assertEquals(1, ($result["remainder"])->int());

        $result = ESInt::init(25)->remainder(4)->int();
        $this->assertEquals(1, $result);
    }

    public function testCanDoArithmatic()
    {
        $result = ESInt::init(25)->sum(5)->int();
        $this->assertEquals(30, $result);

        $result = ESInt::init(25)->difference(5)->int();
        $this->assertEquals(20, $result);

        $result = ESInt::init(25)->difference(-5)->int();
        $this->assertEquals(30, $result);

        $result = ESInt::init(25)->product(-5)->int();
        $this->assertEquals(-125, $result);

        $result = ESInt::init(25)->quotient(5)->int();
        $this->assertEquals(5, $result);
    }

    public function testCanDoComparison()
    {
        $compare = ESInt::init(25);
        $result = ESInt::init(20);
        $this->assertTrue($result->isLessThan($compare)->bool());
        $this->assertFalse($result->isGreaterThan($compare)->bool());

        $compare = ESInt::init(15);
        $result = ESInt::init(20);
        $this->assertFalse($result->isLessThan($compare)->bool());
        $this->assertTrue($result->isGreaterThan($compare)->bool());

        $compare = ESInt::init(20);
        $result = ESInt::init(20);
        $this->assertTrue($result->isLessThan($compare, true)->bool());
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
