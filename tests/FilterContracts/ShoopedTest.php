<?php

namespace Eightfold\Shoop\Tests\FilterContracts;

use Eightfold\Shoop\Tests\FilterContracts\FilterContractsTestCase;
use Eightfold\Shoop\Tests\AssertEqualsFluent;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Tests\FilterContracts\ContractTests\Foldable;

use Eightfold\Shoop\Tests\FilterContracts\ContractTests\Arrayable;
use Eightfold\Shoop\Tests\FilterContracts\ContractTests\Associable;
use Eightfold\Shoop\Tests\FilterContracts\ContractTests\Countable;
use Eightfold\Shoop\Tests\FilterContracts\ContractTests\Stringable;
use Eightfold\Shoop\Tests\FilterContracts\ContractTests\Tupleable;

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
    use Foldable, Arrayable, Associable, Countable, Stringable, Tupleable, Emptiable, Falsifiable, Addable, Subtractable;

    static public function sutClassName(): string
    {
        return Shooped::class;
    }

    /**
     * @test
     * @group current
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
}
