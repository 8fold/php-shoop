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
        $result = ESRange::wrap(1, 5);
        $this->assertEquals(1, $result->min()->unwrap());
        $this->assertEquals(5, $result->max()->unwrap());

        $result = ESRange::wrap(5, 10);
        $this->assertEquals(5, $result->min()->unwrap());
        $this->assertEquals(10, $result->max()->unwrap());

        $result = ESRange::wrap(1, 5, false);
        $this->assertEquals(1, $result->min()->unwrap());
        $this->assertEquals(4, $result->max()->unwrap());

        $result = ESRange::wrap(0, 0);
        $this->assertTrue($result->isEmpty()->bool());

        $result = ESRange::wrap(5, 10);
        $this->assertFalse($result->isEmpty()->bool());

        $result = ESRange::wrap(5, 10);
        $this->assertEquals(5, $result->count()->unwrap());
        $this->assertEquals(5, $result->lowerBound()->unwrap());
        $this->assertEquals(10, $result->upperBound()->unwrap());

        $this->assertTrue($result->contains(ESInt::wrap(8))->bool());
        $this->assertFalse($result->contains(ESInt::wrap(2))->bool());

        $clamped = $result->clampedTo(ESRange::wrap(8, 500));
        $this->assertEquals(8, $clamped->min()->unwrap());
        $this->assertEquals(10, $clamped->max()->unwrap());
    }

    public function testMaxMustBeGreaterThanMin()
    {
        $result = ESRange::wrap(5, 0);
        $this->assertFalse($result->max()->isGreaterThan($result->min())->bool());
    }

    public function testCanIterate()
    {
        $range = ESRange::wrap(5, 100);
        $this->assertEquals(5, $range->current()->unwrap());
        $this->assertEquals(6, $range->next()->current()->unwrap());
        $this->assertEquals(1, $range->key()->unwrap());
        $this->assertEquals(5, $range->rewind()->current()->unwrap());

        $x = 0;
        foreach ($range as $i) {
            $x++;
        }
        $this->assertTrue($x > 0);
        $this->assertEquals(96, $x);

        $this->assertEquals(5, $range->first()->unwrap());
        $this->assertEquals(100, $range->last()->unwrap());

    }

    public function testEquatable()
    {
        $range = ESRange::wrap(5, 100);
        $compare = ESRange::wrap(5, 100);
        $this->assertTrue($range->isSameAs($compare)->unwrap());

        $this->assertFalse($range->isDifferentThan($compare)->unwrap());
    }

    public function testCanBeEnumerated()
    {
        $expected = [0, 1, 2, 3, 4, 5];
        $result = ESRange::wrap(0, 5)->enumerated()->unwrap();
        $this->assertEquals($expected, $result);
    }
}
