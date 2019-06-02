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

    public function testCanRuncomparisons()
    {
        $result = ESInt::wrap(25);
        $compare = ESInt::wrap(25);
        $this->assertTrue($result->isSameAs($compare)->unwrap());

        $result = ESInt::wrap(25);
        $compare = ESInt::wrap(20);
        $this->assertTrue($result->isDifferentThan($compare)->unwrap());
    }

    public function testMultipleOfAndQuotient()
    {
        $five = ESInt::wrap(5);
        $four = $five->minus(ESInt::wrap(1));
        $result = ESInt::wrap(25)->isFactorOf($five)->unwrap();
        $this->assertTrue($result);

        $result = ESInt::wrap(25)->isFactorOf($five->plus(ESInt::wrap(1)))->unwrap();
        $this->assertFalse($result);
    }

    public function testCanDoArithmatic()
    {
        $five = ESInt::wrap(5);
        $result = ESInt::wrap(25)->plus($five)->unwrap();
        $this->assertEquals(30, $result);

        $result = ESInt::wrap(25)->minus($five)->unwrap();
        $this->assertEquals(20, $result);

        $result = ESInt::wrap(25)->dividedBy($five)->unwrap();
        $this->assertEquals(5, $result);
    }

    public function testCanDoComparison()
    {
        $compare = ESInt::wrap(25);
        $result = ESInt::wrap(20);
        $this->assertTrue($result->isLessThan($compare)->unwrap());
        $this->assertFalse($result->isGreaterThan($compare)->unwrap());

        $compare = ESInt::wrap(15);
        $result = ESInt::wrap(20);
        $this->assertFalse($result->isLessThan($compare)->unwrap());
        $this->assertTrue($result->isGreaterThan($compare)->unwrap());

        $compare = ESInt::wrap(20);
        $result = ESInt::wrap(20);
        $this->assertTrue($result->isLessThan($compare, true)->unwrap());
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

    public function testCanMakeNegativeNumberPositiveAgain()
    {
        $result = ESInt::wrap(10);
        $negative = $result->toggle();
        $this->assertEquals(-10, $negative->unwrap());

        $positive = $negative->toggle();
        $this->assertEquals(10, $positive->unwrap());

        $this->assertEquals(10, $result->unwrap());
    }

    public function testCanDoMultiplication()
    {
        $result = ESInt::wrap(3)->multipliedBy(3)->unwrap();
        $this->assertEquals(9, $result);
    }
}
