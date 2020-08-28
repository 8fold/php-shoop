<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Shoop\Tests\TestClasses\AssertEqualsFluent;

use Eightfold\Shoop\Shooped;

trait Reversible
{
    /**
     * @test
     */
    public function reverse()
    {
        AssertEqualsFluent::applyWith(
            true,
            Shooped::class,
            2.46 // 2.13 // 1.93
        )->unfoldUsing(
            Shooped::fold(false)->reverse()
        );

        AssertEqualsFluent::applyWith(
            -3,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(3)->reverse()
        );

        AssertEqualsFluent::applyWith(
            2.0,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(-2.0)->reverse()
        );

        AssertEqualsFluent::applyWith(
            [1, 2, 3],
            Shooped::class
        )->unfoldUsing(
            Shooped::fold([3, 2, 1])->reverse()
        );

        AssertEqualsFluent::applyWith(
            ["b" => 3, "a" => 1],
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3])->reverse()
        );

        AssertEqualsFluent::applyWith(
            "8fold!",
            Shooped::class
        )->unfoldUsing(
            Shooped::fold("!dlof8")->reverse()
        );

        AssertEqualsFluent::applyWith(
            (object) ["c" => 3, "a" => 1],
            Shooped::class,
            3.66
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->reverse()
        );

        // TODO: Objects
    }
}
