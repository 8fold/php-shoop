<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shooped;

trait Reversible
{
    /**
     * @test
     */
    public function reversed()
    {
        AssertEquals::applyWith(
            true,
            "boolean",
            2.46 // 2.13 // 1.93
        )->unfoldUsing(
            Shooped::fold(false)->reversed()
        );

        AssertEquals::applyWith(
            -3,
            "integer"
        )->unfoldUsing(
            Shooped::fold(3)->reversed()
        );

        AssertEquals::applyWith(
            2.0,
            "double"
        )->unfoldUsing(
            Shooped::fold(-2.0)->reversed()
        );

        AssertEquals::applyWith(
            [1, 2, 3],
            "array"
        )->unfoldUsing(
            Shooped::fold([3, 2, 1])->reversed()
        );

        AssertEquals::applyWith(
            ["b" => 3, "a" => 1],
            "array"
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3])->reversed()
        );

        AssertEquals::applyWith(
            "8fold!",
            "string"
        )->unfoldUsing(
            Shooped::fold("!dlof8")->reversed()
        );

        AssertEquals::applyWith(
            (object) ["c" => 3, "a" => 1],
            "object",
            3.66
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->reversed()
        );

        // TODO: Objects
    }
}
