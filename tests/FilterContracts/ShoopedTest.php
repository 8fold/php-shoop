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
     * @group current
     */
    public function asString()
    {
        AssertEqualsFluent::applyWith(
            "true",
            Shooped::class,
            6.48
        )->unfoldUsing(
            Shooped::fold(true)->asString()
        );

        // AssertEqualsFluent::applyWith(
        //     [2, 3],
        //     Shooped::class
        // )->unfoldUsing(
        //     Shooped::fold(3)->asString(2)
        // );

        // AssertEqualsFluent::applyWith(
        //     [0, 1, 2],
        //     Shooped::class
        // )->unfoldUsing(
        //     Shooped::fold(2.5)->asString()
        // );

        // AssertEqualsFluent::applyWith(
        //     [3, 1, 3],
        //     Shooped::class
        // )->unfoldUsing(
        //     Shooped::fold([3, 1, 3])->asString()
        // );

        // AssertEqualsFluent::applyWith(
        //     [1, 3, 1],
        //     Shooped::class
        // )->unfoldUsing(
        //     Shooped::fold(["a" => 1, "b" => 3, "c" => 1])->asString()
        // );

        // AssertEqualsFluent::applyWith(
        //     ["H", "i", "!"],
        //     Shooped::class
        // )->unfoldUsing(
        //     Shooped::fold("Hi!")->asString()
        // );

        // AssertEqualsFluent::applyWith(
        //     ["", "H", "i", ""],
        //     Shooped::class
        // )->unfoldUsing(
        //     Shooped::fold("!H!i!")->asString("!")
        // );

        // AssertEqualsFluent::applyWith(
        //     ["H", "i"],
        //     Shooped::class
        // )->unfoldUsing(
        //     Shooped::fold("!H!i!")->asString("!", false)
        // );

        // AssertEqualsFluent::applyWith(
        //     ["", "H!i!"],
        //     Shooped::class
        // )->unfoldUsing(
        //     Shooped::fold("!H!i!")->asString("!", true, 2)
        // );

        // AssertEqualsFluent::applyWith(
        //     ["H!i!"],
        //     Shooped::class
        // )->unfoldUsing(
        //     Shooped::fold("!H!i!")->asString("!", false, 2)
        // );

        // AssertEqualsFluent::applyWith(
        //     [1, 3],
        //     Shooped::class
        // )->unfoldUsing(
        //     Shooped::fold((object) ["a" => 1, "c" => 3])->asString()
        // );

        // TODO: Objects
    }
}
