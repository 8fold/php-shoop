<?php

namespace Eightfold\Shoop\Tests\Typeable;

use PHPUnit\Framework\TestCase;
use Eightfold\Shoop\Tests\AssertEqualsFluent;

use \stdClass;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESBoolean;
use Eightfold\Shoop\FluentTypes\ESDictionary;
use Eightfold\Shoop\FluentTypes\ESInteger;
use Eightfold\Shoop\FluentTypes\ESJson;
use Eightfold\Shoop\FluentTypes\ESTuple;
use Eightfold\Shoop\FluentTypes\ESString;

/**
 * @group TypeAsFluent
 * @group ArrayFluent
 *
 * The `array()` method typically converts the `Shoop type` to a `PHP indexed array` equivalent.
 *
 * @return Eightfold\Shoop\ESArray
 */
class ArrayTest extends TestCase
{
    /**
     * @test
     */
    public function ESArray()
    {
        AssertEqualsFluent::applyWith(
            [],
            ESArray::class,
            1.7
        )->unfoldUsing(
            Shoop::this([])->asArray()
        );
    }

    /**
     * @test
     */
    public function ESBoolean()
    {
        AssertEqualsFluent::applyWith(
            [false, true],
            ESArray::class,
            1.68
        )->unfoldUsing(
            Shoop::this(true)->asArray()
        );
    }

    /**
     * @test
     */
    public function ESDictionary()
    {
        AssertEqualsFluent::applyWith(
            ["string", true],
            ESArray::class,
            1.37
        )->unfoldUsing(
            Shoop::this(["a" => "string", "b" => true])->asArray()
        );
    }

    /**
     * @test
     */
    public function ESInteger()
    {
        AssertEqualsFluent::applyWith(
            [0, 1, 2, 3, 4, 5],
            ESArray::class,
            1.55
        )->unfoldUsing(
            Shoop::this(5)->asArray()
        );
    }

    /**
     * @test
     */
    public function ESJson()
    {
        AssertEqualsFluent::applyWith(
            ["test"],
            ESArray::class,
            2.22
        )->unfoldUsing(
            Shoop::this('{"test":"test"}')->asArray()
        );
    }

    /**
     * @test
     */
    public function ESTuple()
    {
        AssertEqualsFluent::applyWith(
            [],
            ESArray::class,
            8.49
        )->unfoldUsing(
            Shoop::this(new stdClass)->asArray()
        );
    }

    /**
     * @test
     */
    public function ESString()
    {
        AssertEqualsFluent::applyWith(
            ["h", "e", "l", "l", "o"],
            ESArray::class,
            2.32
        )->unfoldUsing(
            Shoop::this("hello")->asArray()
        );
    }
}
