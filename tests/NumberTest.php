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

        $expected = '{"json":3}';
        $actual = Shoop::int(3)->json();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testManipulate()
    {
        $result = ESInt::fold(10);
        $negative = $result->toggle();
        $this->assertEquals(-10, $negative->unfold());

        $positive = $negative->toggle();
        $this->assertEquals(10, $positive->unfold());
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
