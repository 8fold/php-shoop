<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\ESInt;

class IntTest extends TestCase
{
    public function testCanInitialize()
    {
        $result = ESInt::wrap(5);
        $this->assertNotNull($result);
        $this->assertEquals(5, $result->unwrap());

        $this->assertEquals("5", $result->description());
    }

    public function testCanDoDistanceAndAdvance()
    {
        $result = ESInt::wrap(5)->distance(20)->unwrap();
        $this->assertEquals(15, $result);

        $result = ESInt::wrap(20)->distance(5)->unwrap();
        $this->assertEquals(-15, $result);

        $result = ESInt::wrap(20)->advanced(5)->unwrap();
        $this->assertEquals(25, $result);

        $result = ESInt::wrap(20)->advanced(-5)->unwrap();
        $this->assertEquals(15, $result);
    }

    public function testCanRuncomparisons()
    {
        $result = ESInt::wrap(25);
        $compare = ESInt::wrap(25);
        $this->assertTrue($result->isSameAs($compare)->bool());

        $result = ESInt::wrap(25);
        $compare = ESInt::wrap(20);
        $this->assertTrue($result->isDifferentThan($compare)->bool());
    }

    public function testMultipleOfAndQuotient()
    {
        $five = ESInt::wrap(5);
        $four = $five->minus(ESInt::wrap(1));
        $result = ESInt::wrap(25)->isMultipleOf($five)->bool();
        $this->assertTrue($result);

        $result = ESInt::wrap(25)->isMultipleOf($five->plus(ESInt::wrap(1)))->bool();
        $this->assertFalse($result);

        $result = ESInt::wrap(25)->quotientAndRemainder($four)->values();
        $this->assertEquals(6, ($result["quotient"])->unwrap());
        $this->assertEquals(1, ($result["remainder"])->unwrap());

        $result = ESInt::wrap(25)->remainder($four)->unwrap();
        $this->assertEquals(1, $result);
    }

    public function testCanDoArithmatic()
    {
        $five = ESInt::wrap(5);
        $result = ESInt::wrap(25)->plus($five)->unwrap();
        $this->assertEquals(30, $result);

        $result = ESInt::wrap(25)->minus($five)->unwrap();
        $this->assertEquals(20, $result);

        $result = ESInt::wrap(25)->minus($five->negate())->unwrap();
        $this->assertEquals(30, $result);

        $result = ESInt::wrap(25)->product($five->negate())->unwrap();
        $this->assertEquals(-125, $result);

        $result = ESInt::wrap(25)->quotient($five)->unwrap();
        $this->assertEquals(5, $result);
    }

    public function testCanDoComparison()
    {
        $compare = ESInt::wrap(25);
        $result = ESInt::wrap(20);
        $this->assertTrue($result->isLessThan($compare)->bool());
        $this->assertFalse($result->isGreaterThan($compare)->bool());

        $compare = ESInt::wrap(15);
        $result = ESInt::wrap(20);
        $this->assertFalse($result->isLessThan($compare)->bool());
        $this->assertTrue($result->isGreaterThan($compare)->bool());

        $compare = ESInt::wrap(20);
        $result = ESInt::wrap(20);
        $this->assertTrue($result->isLessThan($compare, true)->bool());
    }

    public function testCanNegateValue()
    {
        $result = ESInt::wrap(500)->negate()->unwrap();
        $this->assertEquals(-500, $result);
    }

    public function testPlusAndMinus()
    {
        $result = ESInt::wrap(3)->plus(5)->unwrap();
        $this->assertEquals(8, $result);

        $result = ESInt::wrap(3)->plus(ESInt::wrap(5))->unwrap();
        $this->assertEquals(8, $result);

        $result = ESInt::wrap(3)->minus(5)->unwrap();
        $this->assertEquals(-2, $result);

        $result = ESInt::wrap(3)->minus(ESInt::wrap(5))->unwrap();
        $this->assertEquals(-2, $result);
    }
}
