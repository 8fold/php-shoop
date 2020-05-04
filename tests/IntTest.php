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
    public function testRange()
    {
        $base = 5;
        $expected = [0, 1, 2, 3, 4, 5];
        $actual = Shoop::int($base)->range();
        $this->assertEquals($expected, $actual->unfold());

        $expected = [4, 5];
        $actual = Shoop::int($base)->range(4);
        $this->assertEquals($expected, $actual->unfold());
    }
}
