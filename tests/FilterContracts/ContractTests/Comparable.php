<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Shooped;

trait Comparable
{
    /**
     * @test
     */
    public function is()
    {
        AssertEquals::applyWith(
            false,
            "boolean",
            1.89
        )->unfoldUsing(
            Shooped::fold(true)->is(false)
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(3)->is(3)
        );

        // TODO: Should these be the same - ??
        //      all whole numbers are literal integers - ??
        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(2.0)->is(2)
        );

        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->is(false)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])
                ->is((object) ["a" => 1, "b" => 3, "c" => 1])
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold("Hi!")->is("Hi!")
        );

        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->is(["a" => 1, "c" => 3])
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function isGreaterThan()
    {
        AssertEquals::applyWith(
            true,
            "boolean",
            2.36
        )->unfoldUsing(
            Shooped::fold(true)->isGreaterThan(false)
        );

        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(3)->isGreaterThan(5)
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(2.0)->isGreaterThan(1.9)
        );

        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->isGreaterThan([3, 1, 3, 1])
        );

        AssertEquals::applyWith(
            true,
            "boolean",
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])
                ->isGreaterThan(["a" => 1, "b" => 3])
        );

        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold("a")->isGreaterThan("b")
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold("b")->isGreaterThan("a")
        );

        // TODO: Not sure rationale here - could use more work and conversation
        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])
                ->isGreaterThan(["a" => 1, "c" => 3])
        );

        // TODO: Objects
    }

    /**
     * @test
     */
    public function isGreaterThanOrEqualTo()
    {
        AssertEquals::applyWith(
            false,
            "boolean",
            2.59
        )->unfoldUsing(
            Shooped::fold(false)->isGreaterThanOrEqualTo(true)
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(3)->isGreaterThanOrEqualTo(3)
        );

        AssertEquals::applyWith(
            false,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(2.0)->isGreaterThanOrEqualTo(2.9)
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->isGreaterThanOrEqualTo([3, 1])
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])
                ->isGreaterThanOrEqualTo(["a" => 1, "b" => 3])
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold("b")->isGreaterThanOrEqualTo("b")
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            Shooped::fold("b")->isGreaterThanOrEqualTo("a")
        );

        // TODO: Not sure rationale here - could use more work and conversation
        AssertEquals::applyWith(
            true,
            "boolean",
            0.61
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])
                ->isGreaterThanOrEqualTo(["a" => 1, "c" => 3])
        );

        // TODO: Objects
    }
}
