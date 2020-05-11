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
    /**
     * The `replace()` method on ESString replaces instances of characters with the given characters. You can also limit the number of replacements made.
     *
     * @return Eightfold\Shoop\ESString
     */
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

    /**
     * The `lowerFirst()` method on ESString returns the original value after ensuring the first character is lowercase.
     *
     * @return Eightfold\Shoop\ESString
     */
    public function testLowerFirst()
    {
        $base = "HELLO!";
        $expected = "hELLO!";
        $actual = Shoop::string($base)->lowerFirst();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * The `uppercase()` method on ESString returns the original value after ensuring *all* letters are upper case.
     *
     * @return Eightfold\Shoop\ESString
     */
    public function testUppercase()
    {
        $base = "hello!";
        $expected = "HELLO!";
        $actual = Shoop::string($base)->uppercase();
        $this->assertEquals($expected, $actual->unfold());
    }
}
