<?php

namespace Eightfold\Shoop\Tests\PipeFilters\Contracts;

use PHPUnit\Framework\TestCase;
use Eightfold\Shoop\Tests\FilterContracts\FilterContractsTestCase;

use Eightfold\Shoop\Tests\FilterContracts\ClassShooped;

/**
 * @group Shooped
 */
class ShoopedTest extends FilterContractsTestCase
{
    static public function sutClassName(): string
    {
        return ClassShooped::class;
    }
}
