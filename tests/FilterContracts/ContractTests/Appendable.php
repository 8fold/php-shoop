<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shooped;

trait Appendable
{
    /**
     * @test
     */
    public function append()
    {
        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(false)->append(1)
        );

        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(false)->append(false)
        );

        AssertEquals::applyWith(
            2,
            "integer"
        )->unfoldUsing(
            Shooped::fold(1)->append(1)
        );

        AssertEquals::applyWith(
            2.5,
            "double"
        )->unfoldUsing(
            Shooped::fold(1.5)->append(1)
        );

        AssertEquals::applyWith(
            [1, 2, 3],
            "array"
        )->unfoldUsing(
            Shooped::fold([1])->append([2, 3])
        );

        AssertEquals::applyWith(
            "8fold!",
            "string"
        )->unfoldUsing(
            Shooped::fold("8fold")->append("!")
        );

        AssertEquals::applyWith(
            (object) ["a" => 1, "b" => 2, "c" => 3],
            "object",
            0.44, // 0.38, // 0.37 // 0.36 // 0.33
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1])->append(["b" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            (object) ["a" => 2, "c" => 3],
            "object",
            0.46 // 0.4 // 0.39 // 0.35
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1])->append((object) ["a" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            (object) ["a" => 1, "i0" => 3],
            "object",
            0.44 // 0.4 // 0.37 // 0.36 // 0.33
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1])->append(3)
        );

        // TODO: Objects
    }
}
