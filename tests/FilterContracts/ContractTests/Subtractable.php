<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shooped;

trait Subtractable
{
    /**
     * @test
     */
    public function minus()
    {
        AssertEquals::applyWith(
            false,
            "boolean",
            20.64, // 2.84 // 2.24 // 0.97
            24
        )->unfoldUsing(
            Shooped::fold(true)->minus(1)
        );

        AssertEquals::applyWith(
            0,
            "integer",
        )->unfoldUsing(
            Shooped::fold(1)->minus(1)
        );

        AssertEquals::applyWith(
            0.5,
            "double"
        )->unfoldUsing(
            Shooped::fold(1.5)->minus(1)
        );

        AssertEquals::applyWith(
            [],
            "array",
            1.14
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->minus(3)
        );

        AssertEquals::applyWith(
            [1],
            "array",
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->minus(1)
        );

        AssertEquals::applyWith(
            [3, 1],
            "array",
            2.03
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->minus(1, false)
        );

        AssertEquals::applyWith(
            [1, 3],
            "array",
            1.51
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->minus(1, true, false)
        );

        AssertEquals::applyWith(
            [1, 1, 1],
            "array",
        )->unfoldUsing(
            Shooped::fold([1, 3, 1, 3, 1])->minus(3, false, false)
        );

        AssertEquals::applyWith(
            ["b" => 3],
            "array",
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->minus(1, false, false)
        );

        $using = <<<EOD

            Hello!


        EOD;
        AssertEquals::applyWith(
            "Hello!",
            "string",
            1.6
        )->unfoldUsing(
            Shooped::fold($using)->minus()
        );

        AssertEquals::applyWith(
            "He!",
            "string"
        )->unfoldUsing(
            Shooped::fold("Hello!")->minus(["l", "o"], false, false)
        );

        AssertEquals::applyWith(
            (object) ["a" => 1],
            "object",
            1.02 // 0.83 // 0.35
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->minus(3, false, false)
        );

        // TODO: Objects
    }
}
