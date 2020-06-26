<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    Shoop,
    ESArray,
    Helpers\Type
};

class IntTest extends TestCase
{
    /**
     * The `range()` method on ESInt creates an ESArray of integers from the given value to the original value (or vice versa).
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
    }
}
