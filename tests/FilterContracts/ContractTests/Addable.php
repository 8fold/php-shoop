<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shooped;

trait Addable
{
    /**
     * @test
     */
    public function plus()
    {
        AssertEquals::applyWith(
            true,
            "boolean",
            11.96 // 5.62 // 2.98 // 2.94 // 2.89 // 2.18 // 1.54
        )->unfoldUsing(
            Shooped::fold(false)->plus(1)
        );

        AssertEquals::applyWith(
            2,
            "integer",
            7.26 // 2.55 // 2.54 // 2.48
        )->unfoldUsing(
            Shooped::fold(1)->plus(1)
        );

        AssertEquals::applyWith(
            2.5,
            "double"
        )->unfoldUsing(
            Shooped::fold(1.5)->plus(1)
        );

        AssertEquals::applyWith(
            [1, 2, 3],
            "array",
            1.33, // 0.57, // 0.52,
            29 // 14
        )->unfoldUsing(
            Shooped::fold([1])->plus([2, 3])
        );

        AssertEquals::applyWith(
            "8fold!",
            "string",
            0.34
        )->unfoldUsing(
            Shooped::fold("8fold")->plus("!")
        );

        AssertEquals::applyWith(
            (object) ["a" => 1, "b" => 2, "c" => 3],
            "object",
            1.1 // 0.99 // 0.82
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1])->plus(["b" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            (object) ["a" => 1, "b" => 2, "c" => 3],
            "object",
            0.73 // 0.6 // 0.49
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1])->plus((object) ["b" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            (object) ["a" => 1, "i0" => 3],
            "object",
            0.5, // 0.49
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1])->plus(3)
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function append_value_can_be_foldable()
    {
        AssertEquals::applyWith(
            "8fold!",
            "string",
            4.59
        )->unfoldUsing(
            Shooped::fold("8fold")->plus(
                Shooped::fold("!")
            )
        );
    }
}
