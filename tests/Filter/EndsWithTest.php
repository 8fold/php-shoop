<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestClasses\TestCase;
use Eightfold\Shoop\Tests\TestClasses\AssertEquals;

use Eightfold\Shoop\Filter\EndsWith;

/**
 * @group EndsWith
 */
class EndsWithTest extends TestCase
{
    /**
     * @test
     */
    public function string()
    {
        $using = "Do you remember when, we using to sing?";

        AssertEquals::applyWith(
            true,
            EndsWith::applyWith("sing?"),
            2.11 // 1.48 // unstable
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            false,
            EndsWith::applyWith("Do you...")
        )->unfoldUsing($using);
    }
}
