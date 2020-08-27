<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Shoop\Tests\TestClasses\AssertEqualsFluent;

use Eightfold\Shoop\Shooped;

trait Tupleable
{
    /**
     * @test
     */
    public function asTuple()
    {
        AssertEqualsFluent::applyWith(
            (object) ["false" => false, "true" => true],
            Shooped::class,
            9.25
        )->unfoldUsing(
            Shooped::fold(true)->asTuple()
        );

        AssertEqualsFluent::applyWith(
            (object) ["i0" => 0, "i1" => 1],
            Shooped::class,
            0.39 // 0.34
        )->unfoldUsing(
            Shooped::fold(1)->asTuple()
        );

        AssertEqualsFluent::applyWith(
            (object) ["content" => "Hi!"],
            Shooped::class
        )->unfoldUsing(
            Shooped::fold("Hi!")->asTuple()
        );

        AssertEqualsFluent::applyWith(
            (object) ["a" => 1, "b" => 3],
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3])->asTuple()
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function efToTuple()
    {
        AssertEqualsFluent::applyWith(
            (object) ["false" => false, "true" => true],
            "object",
            3.39 // 2.95
        )->unfoldUsing(
            Shooped::fold(true)->efToTuple()
        );

        AssertEqualsFluent::applyWith(
            (object) ["i0" => 0, "i1" => 1],
            "object"
        )->unfoldUsing(
            Shooped::fold(1)->efToTuple()
        );

        AssertEqualsFluent::applyWith(
            (object) ["content" => "Hi!"],
            "object"
        )->unfoldUsing(
            Shooped::fold("Hi!")->efToTuple()
        );

        AssertEqualsFluent::applyWith(
            (object) ["a" => 1, "b" => 3],
            "object"
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3])->efToTuple()
        );

        // TODO: Object
    }

    /**
     * @test
     */
    public function asJson()
    {
        AssertEqualsFluent::applyWith(
            '{"false":false,"true":true}',
            Shooped::class,
            3.41 // 2.69 // 2.66
        )->unfoldUsing(
            Shooped::fold(true)->asJson()
        );

        AssertEqualsFluent::applyWith(
            '{"i0":0,"i1":1}',
            Shooped::class,
            0.48
        )->unfoldUsing(
            Shooped::fold(1)->asJson()
        );

        AssertEqualsFluent::applyWith(
            '{"content":"Hi!"}',
            Shooped::class
        )->unfoldUsing(
            Shooped::fold("Hi!")->asJson()
        );

        AssertEqualsFluent::applyWith(
            '{"a":1,"b":3}',
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3])->asJson()
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function efToJson()
    {
        AssertEqualsFluent::applyWith(
            '{"false":false,"true":true}',
            "string",
            3.55 // 2.59
        )->unfoldUsing(
            Shooped::fold(true)->efToJson()
        );

        AssertEqualsFluent::applyWith(
            '{"i0":0,"i1":1}',
            "string",
            0.34
        )->unfoldUsing(
            Shooped::fold(1)->efToJson()
        );

        AssertEqualsFluent::applyWith(
            '{"content":"Hi!"}',
            "string"
        )->unfoldUsing(
            Shooped::fold("Hi!")->efToJson()
        );

        AssertEqualsFluent::applyWith(
            '{"a":1,"b":3}',
            "string"
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3])->efToJson()
        );

        // TODO: Objects
    }
}
