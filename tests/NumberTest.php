<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\ESInt;
use Eightfold\Shoop\Shoop;

class NumberTest extends TestCase
{
    public function testTypeJuggling()
    {
        $expected = [0, 1, 2, 3];
        $actual = Shoop::this(3)->array();
        $this->assertEquals($expected, $actual->unfold());

        $expected = 3;
        $actual = Shoop::this(3)->int();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testManipulate()
    {
        $result = ESInt::fold(10);
        $negative = $result->toggle();
        $this->assertEquals(-10, $negative->unfold());

        $positive = $negative->toggle();
        $this->assertEquals(10, $positive->unfold());

        $expected = 123;
        $actual = Shoop::this(213)->sort();
        $this->assertEquals($expected, $actual->unfold());

        $int = 1234;
        $shoopInt = ESInt::fold($int);

        $result = $shoopInt->start(1, 0);
        $this->assertEquals(101234, $result->unfold());

        $actual = $shoopInt->end(1, 0);
        $this->assertEquals(123410, $actual->unfold());
    }

    public function testSearch()
    {
        $int = 1234;
        $shoopInt = ESInt::fold($int);

        $result = $shoopInt->startsWith(12);
        $this->assertTrue($result->unfold());

        $result = $shoopInt->startsWith(78);
        $this->assertFalse($result->unfold());

        $result = $shoopInt->endsWith(34);
        $this->assertTrue($result->unfold());
    }

    public function testOther()
    {
        $int = Shoop::this(34);

        $expected = [34, 35, 36];
        $actual = $int->range(36);
        $this->assertEquals($expected, $actual->unfold());

        $expected = [30, 31, 32, 33, 34];
        $actual = $int->range(30);
        $this->assertEquals($expected, $actual->unfold());
    }
}
