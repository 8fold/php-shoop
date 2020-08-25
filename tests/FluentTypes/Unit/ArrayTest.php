<?php

namespace Eightfold\Shoop\Tests\FluentTypes\Unit;

use Eightfold\Shoop\Tests\FluentTypes\Unit\UnitTestCase;
use Eightfold\Shoop\Tests\AssertEqualsFluent;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESBoolean;
use Eightfold\Shoop\FluentTypes\ESDictionary;
use Eightfold\Shoop\FluentTypes\ESInteger;
use Eightfold\Shoop\FluentTypes\ESJson;
use Eightfold\Shoop\FluentTypes\ESString;
use Eightfold\Shoop\FluentTypes\ESTuple;

/**
 * @group ArrayFluentUnit
 */
class ArrayTest extends UnitTestCase
{
    static public function sutClassName(): string
    {
        return ESArray::class;
    }

    /**
     * @test
     */
    public function asArray(): void
    {
        AssertEqualsFluent::applyWith(
            [1, 2, 3],
            ESArray::class,
            13.15
        )->unfoldUsing(
            Shoop::this([1, 2, 3])->asArray()
        );
    }

    /**
     * @test
     */
    public function asBoolean(): void
    {
        AssertEqualsFluent::applyWith(
            false,
            ESBoolean::class,
            3.64
        )->unfoldUsing(
            Shoop::this([])->asBoolean()
        );
    }

    /**
     * @test
     */
    public function asDictionary(): void
    {
        AssertEqualsFluent::applyWith(
            ["i0" => "a", "i1" => "b"],
            ESDictionary::class,
            0.48
        )->unfoldUsing(
            Shoop::this(["a", "b"])->asDictionary()
        );
    }

    /**
     * @test
     */
    public function asInteger(): void
    {
        AssertEqualsFluent::applyWith(
            2,
            ESInteger::class,
            0.43
        )->unfoldUsing(
            Shoop::this(["a", "b"])->asInteger()
        );
    }

    /**
     * @test
     */
    public function asJson(): void
    {
        AssertEqualsFluent::applyWith(
            '{"i0":"a","i1":"b"}',
            ESJson::class,
            1.44
        )->unfoldUsing(
            Shoop::this(["a", "b"])->asJson()
        );
    }

    /**
     * @test
     */
    public function asString(): void
    {
        AssertEqualsFluent::applyWith(
            "ab",
            ESString::class,
            1.36
        )->unfoldUsing(
            Shoop::this(["a", "b"])->asString()
        );
    }

    /**
     * @test
     */
    public function asTuple(): void
    {
        AssertEqualsFluent::applyWith(
            (object) ["i0" => "a", "i1" => "b"],
            ESTuple::class,
            1.15
        )->unfoldUsing(
            Shoop::this(["a", "b"])->asTuple()
        );
    }
}
