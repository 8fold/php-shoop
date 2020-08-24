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
     * @test
     *
     * The `join()` method on ESArray is similar to the `imploded()` function from the PHP standard library.
     *
     * @return Eightfold\Shoop\FluentTypes\ESString
     */
    public function join()
    {
        AssertEqualsFluent::applyWith(
             "Hello, World!",
             ESString::class,
             12.48
         )->unfoldUsing(
            Shoop::this(["Hello", "World!"])->asString(", ")
        );
    }

    /**
     * @test
     */
    public function title_builder()
    {
        AssertEqualsFluent::applyWith(
             "First | Second | Third",
             ESString::class,
             3.63
         )->unfoldUsing(
            Shoop::this(["Second", "Third"])
                ->prepend("First")->asString(" | ")
        );
    }

    /**
     * @test
     */
    public function random()
    {
        AssertEqualsFluent::applyWith(
             "hello",
             ESString::class,
             5.49
         )->unfoldUsing(
            Shoop::this(["hello"])->random()
        );

        AssertEqualsFluent::applyWith(
             ["hello", "hello"],
             ESArray::class
         )->unfoldUsing(
            Shoop::this(["hello", "hello", "hello"])->random(2)
        );
    }
}
