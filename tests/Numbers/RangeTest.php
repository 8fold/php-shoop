<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    ESRange,
    ESInt
};

class RangeTest extends TestCase
{
    public function testCanInitialize()
    {
        $result = ESRange::init();
        $this->assertNotNull($result);

        $result = ESRange::init(1, 5);
        $this->assertEquals(1, $result->min()->int());
        $this->assertEquals(5, $result->max()->int());

        $result = ESRange::init(5, 10);
        $this->assertEquals(5, $result->min()->int());
        $this->assertEquals(10, $result->max()->int());

        $result = ESRange::init(1, 5, false);
        $this->assertEquals(1, $result->min()->int());
        $this->assertEquals(4, $result->max()->int());

        $result = ESRange::init();
        $this->assertTrue($result->isEmpty()->bool());

        $result = ESRange::init(5, 10);
        $this->assertFalse($result->isEmpty()->bool());

        $result = ESRange::init(5, 10);
        $this->assertEquals(5, $result->count()->int());
        $this->assertEquals(5, $result->lowerBound()->int());
        $this->assertEquals(10, $result->upperBound()->int());

        $this->assertTrue($result->contains(ESInt::init(8))->bool());
        $this->assertFalse($result->contains(ESInt::init(2))->bool());

        $clamped = $result->clampedTo(ESRange::init(8, 500));
        $this->assertEquals(8, $clamped->min()->int());
        $this->assertEquals(10, $clamped->max()->int());
    }

    public function testMaxMustBeGreaterThanMin()
    {
        $result = ESRange::init(5, 0);
        $this->assertFalse($result->max()->isGreaterThan($result->min())->bool());
    }

    public function testCanIterate()
    {
        $range = ESRange::init(5, 100);
        $this->assertEquals(5, $range->current()->int());
        $this->assertEquals(6, $range->next()->current()->int());
        $this->assertEquals(1, $range->key()->int());
        $this->assertEquals(5, $range->rewind()->current()->int());

        $x = 0;
        foreach ($range as $i) {
            $x++;
        }
        $this->assertTrue($x > 0);
        $this->assertEquals(96, $x);

        $this->assertEquals(5, $range->first()->int());
        $this->assertEquals(100, $range->last()->int());
    }
}
