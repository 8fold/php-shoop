<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shooped;

trait Prependable
{
    /**
     * @test
     */
    public function prepend()
    {
        AssertEquals::applyWith(
            true,
            "boolean",
            1.4, // 0.35, // 0.3,
            14
        )->unfoldUsing(
            Shooped::fold(false)->prepend(1)
        );

        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(false)->prepend(false)
        );

        AssertEquals::applyWith(
            2,
            "integer"
        )->unfoldUsing(
            Shooped::fold(1)->prepend(1)
        );

        AssertEquals::applyWith(
            0.5,
            "double"
        )->unfoldUsing(
            Shooped::fold(1.5)->prepend(-1)
        );

        AssertEquals::applyWith(
            [2, 3, 1],
            "array"
        )->unfoldUsing(
            Shooped::fold([1])->prepend([2, 3])
        );

        AssertEquals::applyWith(
            "!8fold",
            "string"
        )->unfoldUsing(
            Shooped::fold("8fold")->prepend("!")
        );

        AssertEquals::applyWith(
            (object) ["b" => 2, "c" => 3, "a" => 1],
            "object",
            0.39 // 0.37 // 0.36
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1])->prepend(["b" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            (object) ["a" => 1, "c" => 3],
            "object",
            0.48, // 0.41, // 0.4 // 0.34 // 0.33
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1])->prepend((object) ["a" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            (object) ["a" => 1, "i0" => 3],
            "object",
            0.49 // 0.4 // 0.36 // 0.32
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1])->prepend(3)
        );

        // TODO: Objects
    }
}
