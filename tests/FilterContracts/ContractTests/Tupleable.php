<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shooped;

trait Tupleable
{
    /**
     * @test
     */
    public function asTuple()
    {
        AssertEquals::applyWith(
            (object) ["false" => false, "true" => true],
            "object",
            9.25
        )->unfoldUsing(
            Shooped::fold(true)->asTuple()
        );

        AssertEquals::applyWith(
            (object) ["i0" => 0, "i1" => 1],
            "object",
            0.39 // 0.34
        )->unfoldUsing(
            Shooped::fold(1)->asTuple()
        );

        AssertEquals::applyWith(
            (object) ["content" => "Hi!"],
            "object"
        )->unfoldUsing(
            Shooped::fold("Hi!")->asTuple()
        );

        AssertEquals::applyWith(
            (object) ["a" => 1, "b" => 3],
            "object"
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
        AssertEquals::applyWith(
            (object) ["false" => false, "true" => true],
            "object",
            3.39 // 2.95
        )->unfoldUsing(
            Shooped::fold(true)->efToTuple()
        );

        AssertEquals::applyWith(
            (object) ["i0" => 0, "i1" => 1],
            "object",
            0.33 // 0.32
        )->unfoldUsing(
            Shooped::fold(1)->efToTuple()
        );

        AssertEquals::applyWith(
            (object) ["content" => "Hi!"],
            "object"
        )->unfoldUsing(
            Shooped::fold("Hi!")->efToTuple()
        );

        AssertEquals::applyWith(
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
        AssertEquals::applyWith(
            '{"false":false,"true":true}',
            "string",
            3.41 // 2.69 // 2.66
        )->unfoldUsing(
            Shooped::fold(true)->asJson()
        );

        AssertEquals::applyWith(
            '{"i0":0,"i1":1}',
            "string",
            0.48
        )->unfoldUsing(
            Shooped::fold(1)->asJson()
        );

        AssertEquals::applyWith(
            '{"content":"Hi!"}',
            "string"
        )->unfoldUsing(
            Shooped::fold("Hi!")->asJson()
        );

        AssertEquals::applyWith(
            '{"a":1,"b":3}',
            "string"
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
        AssertEquals::applyWith(
            '{"false":false,"true":true}',
            "string",
            3.55 // 2.59
        )->unfoldUsing(
            Shooped::fold(true)->efToJson()
        );

        AssertEquals::applyWith(
            '{"i0":0,"i1":1}',
            "string",
            0.39, // 0.34
        )->unfoldUsing(
            Shooped::fold(1)->efToJson()
        );

        AssertEquals::applyWith(
            '{"content":"Hi!"}',
            "string",
            0.49
        )->unfoldUsing(
            Shooped::fold("Hi!")->efToJson()
        );

        AssertEquals::applyWith(
            '{"a":1,"b":3}',
            "string"
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3])->efToJson()
        );

        // TODO: Objects
    }
}
