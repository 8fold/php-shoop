<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Shoop\Tests\AssertEqualsFluent;

use Eightfold\Shoop\Shooped;

trait Subtractable
{
    /**
     * @test
     */
    public function minus()
    {
        AssertEqualsFluent::applyWith(
            false,
            Shooped::class,
            20.64 // 2.84 // 2.24 // 0.97
        )->unfoldUsing(
            Shooped::fold(true)->minus(1)
        );

        AssertEqualsFluent::applyWith(
            0,
            Shooped::class,
        )->unfoldUsing(
            Shooped::fold(1)->minus(1)
        );

        AssertEqualsFluent::applyWith(
            0.5,
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(1.5)->minus(1)
        );

        AssertEqualsFluent::applyWith(
            [],
            Shooped::class,
            1.14
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->minus(3)
        );

        AssertEqualsFluent::applyWith(
            [1],
            Shooped::class,
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->minus(1)
        );

        AssertEqualsFluent::applyWith(
            [3, 1],
            Shooped::class,
            2.03
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->minus(1, false)
        );

        AssertEqualsFluent::applyWith(
            [1, 3],
            Shooped::class,
        )->unfoldUsing(
            Shooped::fold([3, 1, 3])->minus(1, true, false)
        );

        AssertEqualsFluent::applyWith(
            [1, 1, 1],
            Shooped::class,
        )->unfoldUsing(
            Shooped::fold([1, 3, 1, 3, 1])->minus(3, false, false)
        );

        AssertEqualsFluent::applyWith(
            ["b" => 3],
            Shooped::class,
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->minus(1, false, false)
        );

        $using = <<<EOD

            Hello!


        EOD;
        AssertEqualsFluent::applyWith(
            "Hello!",
            Shooped::class,
            1.6
        )->unfoldUsing(
            Shooped::fold($using)->minus()
        );

        AssertEqualsFluent::applyWith(
            "He!",
            Shooped::class
        )->unfoldUsing(
            Shooped::fold("Hello!")->minus(["l", "o"], false, false)
        );

        AssertEqualsFluent::applyWith(
            (object) ["a" => 1],
            Shooped::class,
            1.02 // 0.83 // 0.35
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "c" => 3])->minus(3, false, false)
        );

        // TODO: Objects
    }
}
