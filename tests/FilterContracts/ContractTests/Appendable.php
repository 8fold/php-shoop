<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shooped;

/**
 * @version 1.0.0
 */
trait Appendable
{
    /**
     * @test
     */
    public function append()
    {
        AssertEquals::applyWith(
            2,
            "integer",
            3.4, // 3.37, // 2.8, // 2.58,
            236 // 235
        )->unfoldUsing(
            Shooped::fold(1)->append(1)
        );

        AssertEquals::applyWith(
            2.5,
            "double",
            0.15, // 0.14, // 0.04,
            1
        )->unfoldUsing(
            Shooped::fold(1.5)->append(1)
        );

        AssertEquals::applyWith(
            [1, 2, 3],
            "array",
            0.08, // 0.02,
            1
        )->unfoldUsing(
            Shooped::fold([1])->append([2, 3])
        );

        AssertEquals::applyWith(
            "8fold!",
            "string",
            0.13, // 0.12, // 0.09,
            4
        )->unfoldUsing(
            Shooped::fold("8fold")->append("!")
        );

        AssertEquals::applyWith(
            (object) ["a" => 1, "b" => 2, "c" => 3],
            "object",
            1.38,
            44
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1])->append(["b" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            (object) ["a" => 2, "c" => 3],
            "object",
            0.05,
            1
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1])
                ->append((object) ["a" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            (object) ["a" => 1, "0.0" => 3],
            "object",
            0.06, // 0.05,
            1
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1])->append(3)
        );

        // TODO: Objects
    }
}
