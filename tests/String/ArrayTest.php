<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Str;

use Eightfold\Shoop\Tests\String\TestStrings;

class ArrayTest extends TestCase
{
    use TestStrings;

//-> Array
    public function testCanSplitWorldByComma()
    {
        $expected = [
            '🌍',
            '🌍',
            '🌍',
            '🌍',
            '🌍'
        ];
        $result = Str::fromString('🌍,🌍,🌍,🌍,🌍')->split(',');
        $this->assertEquals($expected, $result);
    }

    public function testCanSplitCommaByWorldOmitEmpty()
    {
        $expected = [
            ",",
            ",",
            ",",
            ","
        ];
        $result = Str::fromString('🌍,🌍,🌍,🌍,🌍')->split('🌍');
        $this->assertEquals($expected, $result);
    }

    public function testCanSplitCommaByWorldPreserveEmpty()
    {
        $expected = [
            "",
            ",",
            ",",
            ",",
            ",",
            ""
        ];
        $result = Str::fromString('🌍,🌍,🌍,🌍,🌍')->split('🌍', 0, false);
        $this->assertEquals($expected, $result);
    }

    public function testSplitReturnsOneOfTwoPossibles()
    {
        $initial = "Hello, World, how are you?";
        $expected = [
            "Hello",
            " World, how are you?"
        ];
        $result = Str::fromString($initial)->split(',', 1);
        $this->assertEquals($expected, $result);
    }

    public function testSplitReturnsTwoOfTwoPossibles()
    {
        $initial = "Hello, World, how are you?";
        $expected = [
            "Hello",
            " World",
            " how are you?"
        ];
        $result = Str::fromString($initial)->split(',', 2);
        $this->assertEquals($expected, $result);
    }
}
