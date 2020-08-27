<?php

namespace Eightfold\Shoop\Tests\FilterContracts;

use Eightfold\Shoop\Tests\FilterContracts\FilterContractsTestCase;
use Eightfold\Shoop\Tests\AssertEqualsFluent;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Tests\FilterContracts\ContractTests\Foldable;

use Eightfold\Shoop\Tests\FilterContracts\ContractTests\Arrayable;
use Eightfold\Shoop\Tests\FilterContracts\ContractTests\Associable;
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
    use Foldable, Arrayable, Associable, Stringable, Tupleable, Emptiable, Falsifiable, Addable, Subtractable;

    static public function sutClassName(): string
    {
        return Shooped::class;
    }
}
