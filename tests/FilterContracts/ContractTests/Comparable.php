<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Shoop\Tests\TestClasses\AssertEqualsFluent;

use Eightfold\Shoop\Shooped;

trait Comparable
{
    /**
     * @test
     */
    public function is()
    {
        AssertEqualsFluent::applyWith(
            false,
            Shooped::class,
            1.89
        )->unfoldUsing(
            Shooped::fold(true)->is(false)
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(3)->is(3)
        );

        // TODO: Should these be the same - ??
        //      all whole numbers are literal integers - ??
        AssertEqualsFluent::applyWith(
            false,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(2.0)->is(2)
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->is(false)
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class,
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])
                ->is((object) ["a" => 1, "b" => 3, "c" => 1])
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold("Hi!")->is("Hi!")
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class
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
        AssertEqualsFluent::applyWith(
            true,
            Shooped::class,
            2.36
        )->unfoldUsing(
            Shooped::fold(true)->isGreaterThan(false)
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(3)->isGreaterThan(5)
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(2.0)->isGreaterThan(1.9)
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->isGreaterThan([3, 1, 3, 1])
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class,
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])
                ->isGreaterThan(["a" => 1, "b" => 3])
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold("a")->isGreaterThan("b")
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold("b")->isGreaterThan("a")
        );

        // TODO: Not sure rationale here - could use more work and conversation
        AssertEqualsFluent::applyWith(
            true,
            Shooped::class
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
        AssertEqualsFluent::applyWith(
            false,
            Shooped::class,
            2.59
        )->unfoldUsing(
            Shooped::fold(false)->isGreaterThanOrEqualTo(true)
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(3)->isGreaterThanOrEqualTo(3)
        );

        AssertEqualsFluent::applyWith(
            false,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(2.0)->isGreaterThanOrEqualTo(2.9)
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->isGreaterThanOrEqualTo([3, 1])
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])
                ->isGreaterThanOrEqualTo(["a" => 1, "b" => 3])
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold("b")->isGreaterThanOrEqualTo("b")
        );

        AssertEqualsFluent::applyWith(
            true,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold("b")->isGreaterThanOrEqualTo("a")
        );

        // TODO: Not sure rationale here - could use more work and conversation
        AssertEqualsFluent::applyWith(
            true,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])
                ->isGreaterThanOrEqualTo(["a" => 1, "c" => 3])
        );

        // TODO: Objects
    }
}
