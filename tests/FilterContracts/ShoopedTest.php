<?php

namespace Eightfold\Shoop\Tests\FilterContracts;

use Eightfold\Shoop\Tests\FilterContracts\FilterContractsTestCase;
use Eightfold\Shoop\Tests\AssertEqualsFluent;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Tests\FilterContracts\ContractTests\Foldable;

use Eightfold\Shoop\Tests\FilterContracts\ContractTests\Arrayable;
use Eightfold\Shoop\Tests\FilterContracts\ContractTests\Associable;

use Eightfold\Shoop\Tests\FilterContracts\ContractTests\Addable;
use Eightfold\Shoop\Tests\FilterContracts\ContractTests\Subtractable;

use Eightfold\Shoop\Tests\FilterContracts\ContractTests\Falsifiable;
use Eightfold\Shoop\Tests\FilterContracts\ContractTests\Emptiable;

use Eightfold\Shoop\Shooped;

/**
 * @group Shooped
 */
class ShoopedTest extends FilterContractsTestCase
{
    use Foldable, Arrayable, Associable, Emptiable, Falsifiable, Addable, Subtractable;

    static public function sutClassName(): string
    {
        return Shooped::class;
    }

    /**
     * @test
     */
    public function asString()
    {
        AssertEqualsFluent::applyWith(
            "true",
            Shooped::class,
            10.05 // 6.48
        )->unfoldUsing(
            Shooped::fold(true)->asString()
        );

        AssertEqualsFluent::applyWith(
            "3",
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(3)->asString()
        );

        AssertEqualsFluent::applyWith(
            "2.5",
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(2.5)->asString()
        );

        AssertEqualsFluent::applyWith(
            "Hi!",
            Shooped::class,
            1.62
        )->unfoldUsing(
            Shooped::fold(["H", 1, "i", true, "!"])->asString()
        );

        AssertEqualsFluent::applyWith(
            "",
            Shooped::class,
            0.91
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->asString()
        );

        AssertEqualsFluent::applyWith(
            "8fold!",
            Shooped::class,
            4.05
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "b" => "8fold!", "c" => 3])->asString()
        );

        // TODO: Objects
    }

    /**
     * @test
     * @group current
     */
    public function efToString()
    {
        AssertEqualsFluent::applyWith(
            "true",
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(true)->efToString()
        );

        AssertEqualsFluent::applyWith(
            "3",
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(3)->efToString()
        );

        AssertEqualsFluent::applyWith(
            "2.5",
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(2.5)->efToString()
        );

        AssertEqualsFluent::applyWith(
            "Hi!",
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(["H", 1, "i", true, "!"])->efToString()
        );

        AssertEqualsFluent::applyWith(
            "",
            Shooped::class
        )->unfoldUsing(
            Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->efToString()
        );

        AssertEqualsFluent::applyWith(
            "8fold!",
            Shooped::class
        )->unfoldUsing(
            Shooped::fold((object) ["a" => 1, "b" => "8fold!", "c" => 3])->efToString()
        );

        // TODO: Objects
    }
}
