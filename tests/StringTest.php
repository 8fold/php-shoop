<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    Shoop,
    ESArray,
    Helpers\Type
};

class StringTest extends TestCase
{
    public function testReplace()
    {
        $base = "Hello, World!";
        $expected = "Hero, World!";
        $actual = Shoop::string($base)->replace("ll", "r");
        $this->assertEquals($expected, $actual->unfold());

        $base = "abx, xab, bax";
        $expected = "abc, cab, bax";
        $actual = Shoop::string($base)->replace("x", "c", 2);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testLowerFirst()
    {
        $base = "HELLO!";
        $expected = "hELLO!";
        $actual = Shoop::string($base)->lowerFirst();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testUppercase()
    {
        $base = "hello!";
        $expected = "HELLO!";
        $actual = Shoop::string($base)->uppercase();
        $this->assertEquals($expected, $actual->unfold());
    }
}
