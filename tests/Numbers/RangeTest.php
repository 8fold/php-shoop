<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\ESRange;

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
    }

    public function testMaxMustBeGreaterThanMin()
    {
        $result = ESRange::init(5, 0);
        $this->assertFalse($result->max()->isGreaterThan($result->min())->bool());
    }
}
