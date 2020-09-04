<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestClasses\TestCase;
use Eightfold\Shoop\Tests\TestClasses\AssertEquals;

use \stdClass;

use Eightfold\Shoop\Filter\StartsWith;

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
            StartsWith::applyWith("Do you..."),
            0.66 // 0.65 // 0.61 // 0.59
        )->unfoldUsing($using);
    }
}
