<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Shoop\Tests\AssertEqualsFluent;

use Eightfold\Shoop\Shooped;

trait Emptiable
{
    /**
     * @test
     */
    public function _isEmpty()
    {
        AssertEqualsFluent::applyWith(
            false,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(true)->isEmpty()
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(0)->isEmpty()
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(2.5)->isEmpty()
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->isEmpty()
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold([])->isEmpty()
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold("")->isEmpty()
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->isEmpty()
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function efIsEmpty()
    {
        AssertEqualsFluent::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(true)->efIsEmpty()
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(0)->efIsEmpty()
        );

        AssertEqualsFluent::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(2.5)->efIsEmpty()
        );

        AssertEqualsFluent::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->efIsEmpty()
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold([])->efIsEmpty()
        );

        AssertEqualsFluent::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold("")->efIsEmpty()
        );

        AssertEqualsFluent::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->efIsEmpty()
        );

        // TODO: Objects
    }
}
