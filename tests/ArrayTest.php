<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    Shoop,
    ESArray,
    Helpers\Type
};

class ArrayTest extends TestCase
{
    /**
     * The `join()` method on ESArray is similar to the `imploded()` function from the PHP standard library.
     *
     * @return Eightfold\Shoop\ESString
     */
    public function testJoin()
    {
        $base = ["Hello", "World!"];
        $expected = "Hello, World!";
        $actual = ESArray::fold($base)->join(", ");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * The `sum()` method on ESArray is similar to the `array_sum()` function from the PHP standard library.
     *
     * @return Eightfold\Shoop\ESInt
     */
    public function testSum()
    {
        $base = [10, 2, 12];
        $expected = 24;
        $actual = ESArray::fold($base)->sum();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * The `insertAt()` method on ESArray takes the given value and inserts it into the array at the given index.
     *
     * @return Eightfold\Shoop\ESArray
     */
    public function testInsertAt()
    {
        $base = ["Hello", "World!"];
        $expected = ["Hello", ", ", "World!"];
        $actual = ESArray::fold($base)->insertAt(", ", 1);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * The `each()` method on ESArray iterates over each element in the array and passes it through the given closure.
     *
     * @return Eightfold\Shoop\ESArray
     */
    public function testEach()
    {
        $base = ["Hello", ",", " ", "World", "!"];
        $expected = [false, true, true, false, true];
        $actual = ESArray::fold($base)->each(function ($value) {
            return strlen($value) === 1;
        });
        $this->assertEquals($expected, $actual->unfold());

        $expected = [0, 1, 2, 3, 4];
        $indeces = [];
        $actual = ESArray::fold($base)->each(function ($value, $index) use (&$indeces) {
            $indeces[] = $index;
            return strlen($value) === 1;
        });
        $this->assertEquals($expected, $indeces);
    }
}
