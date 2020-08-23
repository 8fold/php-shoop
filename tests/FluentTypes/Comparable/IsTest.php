<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;
use Eightfold\Shoop\Tests\AssertEqualsFluent;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\FluentTypes\ESBoolean;

/**
 * @group IsFluent
 *
 * TODO: Move to PipeFilters ??
 */
class IsTest extends TestCase
{
    /**
     * @test
     */
    public function ESBool()
    {
        $compare = true;
        AssertEqualsFluent::applyWith(
            true,
            ESBoolean::class,
            2.3
        )->unfoldUsing(
            Shoop::this(true)->is($compare)
        );

        AssertEqualsFluent::applyWith(
            false,
            ESBoolean::class
        )->unfoldUsing(
            Shoop::this(false)->is($compare)
        );
    }

    /**
     * @test
     */
    public function ESInteger()
    {
        $compare = 1;
        AssertEqualsFluent::applyWith(
            true,
            ESBoolean::class
        )->unfoldUsing(
            Shoop::this(1)->is($compare)
        );
    }

    /**
     * @test
     */
    public function ESString()
    {
        $compare = "8fold!";
        AssertEqualsFluent::applyWith(
            true,
            ESBoolean::class
        )->unfoldUsing(
            Shoop::this("8fold!")->is($compare)
        );
    }

    /**
     * @test
     */
    public function ESArray()
    {
        $compare = [1, 2, 3];
        AssertEqualsFluent::applyWith(
            true,
            ESBoolean::class
        )->unfoldUsing(
            Shoop::this([1, 2, 3])->is($compare)
        );
    }

    /**
     * @test
     */
    public function ESDictionary()
    {
        $compare = ["a" => 1, "b" => 2, "c" => 3];
        AssertEqualsFluent::applyWith(
            true,
            ESBoolean::class
        )->unfoldUsing(
            Shoop::this(["a" => 1, "b" => 2, "c" => 3])->is($compare)
        );
    }

    /**
     * @test
     */
    public function ESTuple()
    {
        $compare = (object) ["a" => 1, "b" => 2, "c" => 3];
        AssertEqualsFluent::applyWith(
            false,
            ESBoolean::class
        )->unfoldUsing(
            Shoop::this(new class {})->is($compare)
        );

        $compare = json_encode($compare);
        AssertEqualsFluent::applyWith(
            true,
            ESBoolean::class
        )->unfoldUsing(
            Shoop::this('{"a":1,"b":2,"c":3}')->is($compare)
        );
    }
}
