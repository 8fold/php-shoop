<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Shoop\Tests\AssertEqualsFluent;

use Eightfold\Shoop\Tests\FilterContracts\ClassShooped;

trait Addable
{
    /**
     * @test
     */
    public function plus()
    {
        AssertEqualsFluent::applyWith(
            true,
            ClassShooped::class,
            11.96 // 5.62 // 2.98 // 2.94 // 2.89 // 2.18 // 1.54
        )->unfoldUsing(
            ClassShooped::fold(false)->plus(1)
        );

        AssertEqualsFluent::applyWith(
            2,
            ClassShooped::class,
            7.26 // 2.55 // 2.54 // 2.48
        )->unfoldUsing(
            ClassShooped::fold(1)->plus(1)
        );

        AssertEqualsFluent::applyWith(
            2.5,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold(1.5)->plus(1)
        );

        AssertEqualsFluent::applyWith(
            [1, 2, 3],
            ClassShooped::class,
            0.52
        )->unfoldUsing(
            ClassShooped::fold([1])->plus([2, 3])
        );

        AssertEqualsFluent::applyWith(
            (object) ["a" => 1, "b" => 2, "c" => 3],
            ClassShooped::class,
            1.1 // 0.99 // 0.82
        )->unfoldUsing(
            ClassShooped::fold((object) ["a" => 1])->plus(["b" => 2, "c" => 3])
        );

        AssertEqualsFluent::applyWith(
            (object) ["a" => 1, "b" => 2, "c" => 3],
            ClassShooped::class,
            0.49
        )->unfoldUsing(
            ClassShooped::fold((object) ["a" => 1])->plus((object) ["b" => 2, "c" => 3])
        );

        AssertEqualsFluent::applyWith(
            (object) ["a" => 1, "i0" => 3],
            ClassShooped::class,
            0.49
        )->unfoldUsing(
            ClassShooped::fold((object) ["a" => 1])->plus(3)
        );

        // TODO: Objects
    }
}
