<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Shoop\Tests\AssertEqualsFluent;

use Eightfold\Shoop\Tests\FilterContracts\ClassShooped;

trait Subtractable
{
    /**
     * @test
     */
    public function minus()
    {
        AssertEqualsFluent::applyWith(
            false,
            ClassShooped::class,
            20.64 // 2.84 // 2.24 // 0.97
        )->unfoldUsing(
            ClassShooped::fold(true)->minus(1)
        );

        AssertEqualsFluent::applyWith(
            0,
            ClassShooped::class,
        )->unfoldUsing(
            ClassShooped::fold(1)->minus(1)
        );

        AssertEqualsFluent::applyWith(
            0.5,
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold(1.5)->minus(1)
        );

        AssertEqualsFluent::applyWith(
            [],
            ClassShooped::class,
            1.14
        )->unfoldUsing(
            ClassShooped::fold([3, 1, 3])->minus(3)
        );

        AssertEqualsFluent::applyWith(
            [1],
            ClassShooped::class,
        )->unfoldUsing(
            ClassShooped::fold([3, 1, 3])->minus(1)
        );

        AssertEqualsFluent::applyWith(
            [3, 1],
            ClassShooped::class,
            2.03
        )->unfoldUsing(
            ClassShooped::fold([3, 1, 3])->minus(1, false)
        );

        AssertEqualsFluent::applyWith(
            [1, 3],
            ClassShooped::class,
        )->unfoldUsing(
            ClassShooped::fold([3, 1, 3])->minus(1, true, false)
        );

        AssertEqualsFluent::applyWith(
            [1, 1, 1],
            ClassShooped::class,
        )->unfoldUsing(
            ClassShooped::fold([1, 3, 1, 3, 1])->minus(3, false, false)
        );

        AssertEqualsFluent::applyWith(
            ["b" => 3],
            ClassShooped::class,
        )->unfoldUsing(
            ClassShooped::fold(["a" => 1, "b" => 3, "c" => 1])->minus(1, false, false)
        );

        $using = <<<EOD

            Hello!


        EOD;
        AssertEqualsFluent::applyWith(
            "Hello!",
            ClassShooped::class,
            1.6
        )->unfoldUsing(
            ClassShooped::fold($using)->minus()
        );

        AssertEqualsFluent::applyWith(
            "He!",
            ClassShooped::class
        )->unfoldUsing(
            ClassShooped::fold("Hello!")->minus(["l", "o"], false, false)
        );

        AssertEqualsFluent::applyWith(
            (object) ["a" => 1],
            ClassShooped::class,
            1.02 // 0.83 // 0.35
        )->unfoldUsing(
            ClassShooped::fold((object) ["a" => 1, "c" => 3])->minus(3, false, false)
        );

        // TODO: Objects
    }
}
