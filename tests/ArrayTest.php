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
    public function testJoin()
    {
        $base = ["Hello", "World!"];
        $expected = "Hello, World!";
        $actual = ESArray::fold($base)->join(", ");
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testSum()
    {
        $base = [10, 2, 12];
        $expected = 24;
        $actual = ESArray::fold($base)->sum();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testInsertAt()
    {
        $base = ["Hello", "World!"];
        $expected = ["Hello", ", ", "World!"];
        $actual = ESArray::fold($base)->insertAt(", ", 1);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testEach()
    {
        $base = ["Hello", ",", " ", "World", "!"];
        $expected = [false, true, true, false, true];
        $actual = ESArray::fold($base)->each(function ($value) {
            return strlen($value) === 1;
        });
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testTitleBuilder()
    {
        $expected = "First | Second | Third";
        $actual = Shoop::array(["Second", "Third"])->start("First")->join(" | ");
        $this->assertEquals($expected, $actual->unfold());
    }
}
