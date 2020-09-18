<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Filter\Count;

/**
 * @group Count
 */
class CountTest extends TestCase
{
    /**
     * @test
     */
    public function string()
    {
        AssertEquals::applyWith(
            6,
            "integer",
            0.001,
            1
        )->unfoldUsing(
            Count::apply()->unfoldUsing("8fold!")
        );
    }
}
