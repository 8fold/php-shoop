<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shooped;

trait Emptiable
{
    /**
     * @test
     */
    public function _isEmpty()
    {
        AssertEquals::applyWith(
            false,
            "boolean",
            0.76 // 0.74
        )->unfoldUsing(
            Shooped::fold(true)->isEmpty()
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(0)->isEmpty()
        );

        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(2.5)->isEmpty()
        );

        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->isEmpty()
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold([])->isEmpty()
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold("")->isEmpty()
        );

        AssertEquals::applyWith(
            false,
            "boolean"
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
        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(true)->efIsEmpty()
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(0)->efIsEmpty()
        );

        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(2.5)->efIsEmpty()
        );

        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->efIsEmpty()
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold([])->efIsEmpty()
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold("")->efIsEmpty()
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.65
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->efIsEmpty()
        );

        // TODO: Objects
    }
}
