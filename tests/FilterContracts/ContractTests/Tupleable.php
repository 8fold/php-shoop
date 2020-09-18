<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shooped;

/**
 * @version 1.0.0
 */
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
            9.25,
            232
        )->unfoldUsing(
            Shooped::fold(true)->asTuple()
        );

        AssertEquals::applyWith(
            (object) ["0.0" => 1],
            "object",
            0.39, // 0.34
            72
        )->unfoldUsing(
            Shooped::fold(1)->asTuple()
        );

        AssertEquals::applyWith(
            (object) ["content" => "Hi!"],
            "object",
            0.18,
            7
        )->unfoldUsing(
            Shooped::fold("Hi!")->asTuple()
        );

        AssertEquals::applyWith(
            (object) ["a" => 1, "b" => 3],
            "object",
            0.04,
            1
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
            3.55, // 2.91,
            232
        )->unfoldUsing(
            Shooped::fold(true)->efToTuple()
        );

        AssertEquals::applyWith(
            (object) ["0.0" => 1],
            "object",
            0.22, // 0.21,
            72
        )->unfoldUsing(
            Shooped::fold(1)->efToTuple()
        );

        AssertEquals::applyWith(
            (object) ["content" => "Hi!"],
            "object",
            0.23, // 0.16,
            6
        )->unfoldUsing(
            Shooped::fold("Hi!")->efToTuple()
        );

        AssertEquals::applyWith(
            (object) ["a" => 1, "b" => 3],
            "object",
            0.02,
            1
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
            3.63, // 3.48,
            264
        )->unfoldUsing(
            Shooped::fold(true)->asJson()
        );

        AssertEquals::applyWith(
            '{"0.0":1}',
            "string",
            0.21, // 0.18,
            6
        )->unfoldUsing(
            Shooped::fold(1)->asJson()
        );

        AssertEquals::applyWith(
            '{"content":"Hi!"}',
            "string",
            0.1,
            2
        )->unfoldUsing(
            Shooped::fold("Hi!")->asJson()
        );

        AssertEquals::applyWith(
            '{"a":1,"b":3}',
            "string",
            0.03,
            1
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
            3.52, // 3.22,
            264
        )->unfoldUsing(
            Shooped::fold(true)->efToJson()
        );

        AssertEquals::applyWith(
            '{"0.0":1}',
            "string",
            0.14,
            6
        )->unfoldUsing(
            Shooped::fold(1)->efToJson()
        );

        AssertEquals::applyWith(
            '{"content":"Hi!"}',
            "string",
            0.1,
            2
        )->unfoldUsing(
            Shooped::fold("Hi!")->efToJson()
        );

        AssertEquals::applyWith(
            '{"a":1,"b":3}',
            "string",
            0.03,
            1
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3])->efToJson()
        );

        // TODO: Objects
    }
}
