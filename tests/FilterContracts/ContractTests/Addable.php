<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Shoop\Tests\AssertEqualsFluent;

use Eightfold\Shoop\Shooped;

trait Addable
{
    /**
     * @test
     */
    public function plus()
    {
        AssertEqualsFluent::applyWith(
            true,
            Shooped::class,
            11.96 // 5.62 // 2.98 // 2.94 // 2.89 // 2.18 // 1.54
        )->unfoldUsing(
            Shooped::fold(false)->plus(1)
        );

        AssertEqualsFluent::applyWith(
            2,
            Shooped::class,
            7.26 // 2.55 // 2.54 // 2.48
        )->unfoldUsing(
            Shooped::fold(1)->plus(1)
        );

        AssertEqualsFluent::applyWith(
            2.5,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(1.5)->plus(1)
        );

        AssertEqualsFluent::applyWith(
            [1, 2, 3],
            Shooped::class,
            0.52
        )->unfoldUsing(
            Shooped::fold([1])->plus([2, 3])
        );

        AssertEqualsFluent::applyWith(
            (object) ["a" => 1, "b" => 2, "c" => 3],
            Shooped::class,
            1.1 // 0.99 // 0.82
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1])->plus(["b" => 2, "c" => 3])
        );

        AssertEqualsFluent::applyWith(
            (object) ["a" => 1, "b" => 2, "c" => 3],
            Shooped::class,
            0.49
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1])->plus((object) ["b" => 2, "c" => 3])
        );

        AssertEqualsFluent::applyWith(
            (object) ["a" => 1, "i0" => 3],
            Shooped::class,
            0.49
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1])->plus(3)
        );

        // TODO: Objects
    }
}
