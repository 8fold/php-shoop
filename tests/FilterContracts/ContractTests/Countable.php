<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Shoop\Tests\AssertEqualsFluent;

use Eightfold\Shoop\Shooped;

trait Countable
{
    /**
     * @test
     */
    public function asInteger()
    {
        AssertEqualsFluent::applyWith(
            1,
            Shooped::class,
            5.28
        )->unfoldUsing(
            Shooped::fold(true)->asInteger()
        );

        AssertEqualsFluent::applyWith(
            3,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(3)->asInteger()
        );

        AssertEqualsFluent::applyWith(
            2,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(2.5)->asInteger()
        );

        AssertEqualsFluent::applyWith(
            4,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold([3, 1, 3, 1])->asInteger()
        );

        AssertEqualsFluent::applyWith(
            3,
            Shooped::class,
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->asInteger()
        );

        AssertEqualsFluent::applyWith(
            3,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold("Hi!")->asInteger()
        );

        AssertEqualsFluent::applyWith(
            2,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->asInteger()
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function efToInteger()
    {
        AssertEqualsFluent::applyWith(
            1,
            "integer",
            1.93
        )->unfoldUsing(
            Shooped::fold(true)->efToInteger()
        );

        AssertEqualsFluent::applyWith(
            3,
            "integer"
        )->unfoldUsing(
            Shooped::fold(3)->efToInteger()
        );

        AssertEqualsFluent::applyWith(
            2,
            "integer"
        )->unfoldUsing(
            Shooped::fold(2.5)->efToInteger()
        );

        AssertEqualsFluent::applyWith(
            4,
            "integer"
        )->unfoldUsing(
            Shooped::fold([3, 1, 3, 1])->efToInteger()
        );

        AssertEqualsFluent::applyWith(
            3,
            "integer"
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->efToInteger()
        );

        AssertEqualsFluent::applyWith(
            3,
            "integer"
        )->unfoldUsing(
            Shooped::fold("Hi!")->efToInteger()
        );

        AssertEqualsFluent::applyWith(
            2,
            "integer"
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->efToInteger()
        );

        // TODO: Objects
    }
}
