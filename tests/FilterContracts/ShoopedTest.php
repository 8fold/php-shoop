<?php

namespace Eightfold\Shoop\Tests\PipeFilters\Contracts;

use Eightfold\Shoop\Tests\FilterContracts\FilterContractsTestCase;
use Eightfold\Shoop\Tests\AssertEqualsFluent;

use Eightfold\Shoop\Tests\FilterContracts\ClassShooped;

use Eightfold\Shoop\FilterContracts\Typeable;

use Eightfold\Shoop\FilterContracts\Addable;

/**
 * @group Shooped
 */
class ShoopedTest extends FilterContractsTestCase
{
    static public function sutClassName(): string
    {
        return ClassShooped::class;
    }

    /**
     * @test
     */
    public function fold()
    {
        $expected = false;
        $instance = ClassShooped::fold($expected);
        $actual   = $instance->args(true)[0];
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function unfold()
    {
        $expected = true;
        $actual   = ClassShooped::fold($expected)->unfold();
        $this->assertEquals($expected, $actual);
    }

// - Maths

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
        )->unfoldUsing(
            ClassShooped::fold([1])->plus([2, 3])
        );

        AssertEqualsFluent::applyWith(
            (object) ["a" => 1, "b" => 2, "c" => 3],
            ClassShooped::class,
            0.99 // 0.82
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
            0.35
        )->unfoldUsing(
            ClassShooped::fold((object) ["a" => 1, "c" => 3])->minus(3, false, false)
        );

        // TODO: Objects
    }

// - Arrayable

}
