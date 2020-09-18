<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shooped;

trait Appendable
{
    /**
     * @test
     * @group current
     */
    public function append()
    {
        AssertEquals::applyWith(
            true,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Shooped::fold(false)->append(1)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Shooped::fold(false)->append(false)
        );

        AssertEquals::applyWith(
            2,
            "integer",
            0.001,
            1
        )->unfoldUsing(
            Shooped::fold(1)->append(1)
        );

        AssertEquals::applyWith(
            2.5,
            "double",
            0.001,
            1
        )->unfoldUsing(
            Shooped::fold(1.5)->append(1)
        );

        AssertEquals::applyWith(
            [1, 2, 3],
            "array",
            0.001,
            1s
        )->unfoldUsing(
            Shooped::fold([1])->append([2, 3])
        );

        AssertEquals::applyWith(
            "8fold!",
            "string",
            0.001,
            1
        )->unfoldUsing(
            Shooped::fold("8fold")->append("!")
        );

        AssertEquals::applyWith(
            (object) ["a" => 1, "b" => 2, "c" => 3],
            "object",
            0.001,
            1
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1])->append(["b" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            (object) ["a" => 2, "c" => 3],
            "object",
            0.001,
            1
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1])
                ->append((object) ["a" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            (object) ["a" => 1, "i0" => 3],
            "object",
            0.001,
            1
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1])->append(3)
        );

        // TODO: Objects
    }
}
