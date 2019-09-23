<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\ESInt;

class IntTest extends TestCase
{
    public function testCanInitialize()
    {
        $result = ESInt::fold(5);
        $this->assertNotNull($result);
        $this->assertEquals(5, $result->unfold());
    }

    public function testCanRuncomparisons()
    {
        $result = ESInt::fold(25);
        $compare = ESInt::fold(25);
        $this->assertTrue($result->isSame($compare)->unfold());

        $result = ESInt::fold(25);
        $compare = ESInt::fold(20);
        $this->assertTrue($result->isNot($compare)->unfold());
    }

    public function testMultipleOfAndQuotient()
    {
        $five = ESInt::fold(5);
        $four = $five->minus(ESInt::fold(1));
        $result = ESInt::fold(25)->isFactorOf($five)->unfold();
        $this->assertTrue($result);

        $result = ESInt::fold(25)->isFactorOf($five->plus(ESInt::fold(1)))->unfold();
        $this->assertFalse($result);
    }

    public function testCanDoArithmatic()
    {
        $five = ESInt::fold(5);
        $result = ESInt::fold(25)->plus($five)->unfold();
        $this->assertEquals(30, $result);

        $result = ESInt::fold(25)->minus($five)->unfold();
        $this->assertEquals(20, $result);

        $result = ESInt::fold(25)->dividedBy($five)->unfold();
        $this->assertEquals(5, $result);
    }

    public function testCanDoComparison()
    {
        $compare = ESInt::fold(25);
        $result = ESInt::fold(20);
        $this->assertTrue($result->isLessThan($compare)->unfold());
        $this->assertFalse($result->isGreaterThan($compare)->unfold());

        $compare = ESInt::fold(15);
        $result = ESInt::fold(20);
        $this->assertFalse($result->isLessThan($compare)->unfold());
        $this->assertTrue($result->isGreaterThan($compare)->unfold());

        $compare = ESInt::fold(20);
        $result = ESInt::fold(20);
        $this->assertTrue($result->isLessThan($compare, true)->unfold());
    }

    public function testPlusAndMinus()
    {
        $result = ESInt::fold(3)->plus(5)->unfold();
        $this->assertEquals(8, $result);

        $result = ESInt::fold(3)->plus(ESInt::fold(5))->unfold();
        $this->assertEquals(8, $result);

        $result = ESInt::fold(3)->minus(5)->unfold();
        $this->assertEquals(-2, $result);

        $result = ESInt::fold(3)->minus(ESInt::fold(5))->unfold();
        $this->assertEquals(-2, $result);
    }

    public function testCanMakeNegativeNumberPositiveAgain()
    {
        $result = ESInt::fold(10);
        $negative = $result->toggle();
        $this->assertEquals(-10, $negative->unfold());

        $positive = $negative->toggle();
        $this->assertEquals(10, $positive->unfold());

        $this->assertEquals(10, $result->unfold());
    }

    public function testCanDoMultiplication()
    {
        $result = ESInt::fold(3)->multipliedBy(3)->unfold();
        $this->assertEquals(9, $result);
    }

    public function testCanVerifyIsNotLessThan()
    {
        $result = ESInt::fold(10)->isNotLessThanUnfolded(10);
        $this->assertTrue($result);

        $result = ESInt::fold(10)->isNotLessThanUnfolded(9);
        $this->assertTrue($result);

        $result = ESInt::fold(10)->isNotLessThanUnfolded(11);
        $this->assertFalse($result);
    }

    public function testCanVerifyIsNotGreaterThan()
    {
        $result = ESInt::fold(10)->isNotGreaterThanUnfolded(10);
        $this->assertTrue($result);

        $result = ESInt::fold(10)->isNotGreaterThanUnfolded(11);
        $this->assertTrue($result);

        $result = ESInt::fold(10)->isNotGreaterThanUnfolded(9);
        $this->assertFalse($result);
    }
}
