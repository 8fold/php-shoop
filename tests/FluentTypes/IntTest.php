<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    Helpers\Type
};

class IntTest extends TestCase
{
    /**
     * The `range()` method on ESInteger creates an ESArray of integers from the given value to the original value (or vice versa).
     *
     * @return Eightfold\Shoop\ESArray
     */
    public function testRange()
    {
        $base = 5;
        $expected = [0, 1, 2, 3, 4, 5];
        $actual = Shoop::int($base)->range();
        $this->assertEquals($expected, $actual->unfold());

        $expected = [4, 5];
        $actual = Shoop::int($base)->range(4);
        $this->assertEquals($expected, $actual->unfold());

        $expected = [5, 6, 7, 8, 9, 10];
        $actual = Shoop::int($base)->range(10);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testRoundUpAndDown()
    {
        $expected = 2;
        $actual = Shoop::int(12)->roundUp(10);
        $this->assertSame($expected, $actual->unfold());

        $actual = Shoop::int(29)->roundDown(10);
        $this->assertSame($expected, $actual->unfold());

        $actual = Shoop::int(Shoop::int(29))->roundDown(Shoop::int(10));
        $this->assertSame($expected, $actual->unfold());
    }

    public function testEvenOrOdd()
    {
        $actual = Shoop::int(10)->isEven;
        $this->assertTrue($actual);

        $actual = Shoop::int(11)->isEven;
        $this->assertFalse($actual);

        $actual = Shoop::int(10)->isOdd;
        $this->assertFalse($actual);

        $actual = Shoop::int(11)->isOdd;
        $this->assertTrue($actual);
    }

    public function testMinMax()
    {
        $expected = 10;
        $actual = Shoop::int(5)->max(Shoop::int(10), 8, 0);
        $this->assertEquals($expected, $actual->unfold());

        $expected = 0;
        $actual = Shoop::int(5)->min(Shoop::int(10), 8, 0);
        $this->assertEquals($expected, $actual->unfold());
    }
}
