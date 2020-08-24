<?php

namespace Eightfold\Shoop\FluentTypes\Tests;

use PHPUnit\Framework\TestCase;
use Eightfold\Shoop\Tests\AssertEqualsFluent;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESString;

/**
 * @group ArrayFluent
 */
class ArrayTest extends TestCase
{
    /**
     * The `join()` method on ESArray is similar to the `imploded()` function from the PHP standard library.
     *
     * @return Eightfold\Shoop\FluentTypes\ESString
     */
    public function testJoin()
    {
        AssertEqualsFluent::applyWith(
             "Hello, World!",
             ESString::class,
             2.76
         )->unfoldUsing(ESArray::fold(["Hello", "World!"])->join(", "));
    }

    /**
     * The `sum()` method on ESArray is similar to the `array_sum()` function from the PHP standard library.
     *
     * @return Eightfold\Shoop\ESInteger
     */
    public function testSum()
    {
        $base = [10, 2, 12];
        $expected = 24;
        $actual = ESArray::fold($base)->sum();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testTitleBuilder()
    {
        $expected = "First | Second | Third";
        $actual = Shoop::this(["Second", "Third"])->start("First")->join(" | ");
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testRandom()
    {
        $expected = Shoop::this([Shoop::this("hello")]);
        $actual = Shoop::this(["hello"])->random();
        $this->assertEquals($expected, $actual);

        $expected = Shoop::this([Shoop::this(1)]);
        $actual = Shoop::this([Shoop::this(1)])->random();
        $this->assertEquals($expected, $actual);

        $expected = Shoop::this([TestShooped::fold("/path")]);
        $actual = Shoop::this([TestShooped::fold("/path")])->random();
        $this->assertEquals($expected, $actual);
    }

    public function testFilter()
    {
        $integers = [0, 1, 2, 3, 4, 5, 6];
        $expected = [0, 2, 4, 6];
        $actual = Shoop::this($integers)->filter(function($int) {
            return ! ($int & 1);
        });
        $this->assertEquals($expected, $actual->unfold());

        $expected = [1, 3, 5];
        $actual = Shoop::this($integers)->filter(function($int) {
            return $int & 1;
        });
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testFlatten()
    {
        $base = [
            "hello" => [1, 2, 3],
            "two" => ["one", "two", "three"]
        ];
        $expected = [1, 2, 3, "one", "two", "three"];
        $actual = Shoop::this($base)->flatten;
        $this->assertSame($expected, $actual);
    }
}
