<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    Helpers\Type
};

use Eightfold\Shoop\Tests\TestShooped;

class ArrayTest extends TestCase
{
    /**
     * The `join()` method on ESArray is similar to the `imploded()` function from the PHP standard library.
     *
     * @return Eightfold\Shoop\FluentTypes\ESString
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
     * @return Eightfold\Shoop\ESInteger
     */
    public function testSum()
    {
        $base = [10, 2, 12];
        $expected = 24;
        $actual = ESArray::fold($base)->sum();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * The `each()` method on ESArray iterates over each element in the array and passes it through the given closure.
     *
     * The closure can take up to three arguments:
     *
     * 1. The first is the value from the array or dictionary.
     * 2. The second is the member from the array or dictionary.
     * 3. The third uses PHP's pass by reference (&) and allows users to break out of the loop by setting the value of `break` to true.
     *
     * Note: PHP's `break` functionality is used at the end of the loop; therefore, users who want to break out of the loop at arbitrary points are encouraged to use various PHP loops instead.
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

        $expected = [0, 1, 2];
        $indeces = [];
        $actual = ESArray::fold($base)->each(function ($value, $index, &$break) {
            if ($index === 2) {
                $break = true;
            }

            return $index;
        });
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testTitleBuilder()
    {
        $expected = "First | Second | Third";
        $actual = Shoop::array(["Second", "Third"])->start("First")->join(" | ");
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testRandom()
    {
        $expected = Shoop::array([Shoop::string("hello")]);
        $actual = Shoop::array(["hello"])->random();
        $this->assertEquals($expected, $actual);

        $expected = Shoop::array([Shoop::integer(1)]);
        $actual = Shoop::array([Shoop::integer(1)])->random();
        $this->assertEquals($expected, $actual);

        $expected = Shoop::array([TestShooped::fold("/path")]);
        $actual = Shoop::array([TestShooped::fold("/path")])->random();
        $this->assertEquals($expected, $actual);
    }

    public function testFilter()
    {
        $integers = [0, 1, 2, 3, 4, 5, 6];
        $expected = [0, 2, 4, 6];
        $actual = Shoop::array($integers)->filter(function($int) {
            return ! ($int & 1);
        });
        $this->assertEquals($expected, $actual->unfold());

        $expected = [1, 3, 5];
        $actual = Shoop::array($integers)->filter(function($int) {
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
        $actual = Shoop::array($base)->flatten;
        $this->assertSame($expected, $actual);
    }
}
