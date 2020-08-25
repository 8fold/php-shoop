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
     * @group current
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
}
