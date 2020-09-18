<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shooped;

/**
 * @version 1.0.0
 */
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
            3.14, // 3,
            218
        )->unfoldUsing(
            Shooped::fold(true)->isEmpty()
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.16, // 0.15, // 0.14,
            4
        )->unfoldUsing(
            Shooped::fold(0)->isEmpty()
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.03, // 0.02,
            1
        )->unfoldUsing(
            Shooped::fold(2.5)->isEmpty()
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.08, // 0.07,
            2
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->isEmpty()
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.02,
            1
        )->unfoldUsing(
            Shooped::fold([])->isEmpty()
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.15, // 0.11, // 0.1, // 0.08,
            4
        )->unfoldUsing(
            Shooped::fold("")->isEmpty()
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.6, // 0.53,
            29
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
            "boolean",
            3.14, // 2.72,
            218
        )->unfoldUsing(
            Shooped::fold(true)->efIsEmpty()
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.2, // 0.14,
            4
        )->unfoldUsing(
            Shooped::fold(0)->efIsEmpty()
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.02,
            1
        )->unfoldUsing(
            Shooped::fold(2.5)->efIsEmpty()
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.09, // 0.08,
            1
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->efIsEmpty()
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.02,
            1
        )->unfoldUsing(
            Shooped::fold([])->efIsEmpty()
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.11, // 0.1,
            4
        )->unfoldUsing(
            Shooped::fold("")->efIsEmpty()
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.6, // 0.53, // 0.52, // 0.49,
            29
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->efIsEmpty()
        );

        // TODO: Objects
    }
}
