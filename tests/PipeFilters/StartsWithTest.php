<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;
use Eightfold\Shoop\Tests\AssertEquals;

use \stdClass;

use Eightfold\Shoop\PipeFilters\StartsWith;

/**
 * @group StartsWith
 */
class StartsWithTest extends TestCase
{
    /**
     * @test
     */
    public function string()
    {
        $using = "Do you remember when, we using to sing?";

        AssertEquals::applyWith(
            true,
            StartsWith::applyWith("Do you"),
            3.36
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            false,
            StartsWith::applyWith("Do you...")
        )->unfoldUsing($using);
    }
}
