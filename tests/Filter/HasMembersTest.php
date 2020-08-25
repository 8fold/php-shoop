<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;
use Eightfold\Shoop\Tests\AssertEquals;

use \stdClass;

use Eightfold\Shoop\Filter\HasMembers;

/**
 * @group HasMembers
 */
class HasMembersTest extends TestCase
{
    /**
     * @test
     */
    public function booleans()
    {
        AssertEquals::applyWith(
            true,
            HasMembers::applyWith(1),
            3.39
        )->unfoldUsing(true);

        AssertEquals::applyWith(
            true,
            HasMembers::applyWith(["false", "true"], false),
            0.95
        )->unfoldUsing(false);
    }

    /**
     * @test
     */
    public function tuples()
    {
        $using = (object) ["first" => 0, "second" => true];

        AssertEquals::applyWith(
            true,
            HasMembers::applyWith(["first", "second"], false),
            1
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            true,
            HasMembers::applyWith("second"),
            1.13
        )->unfoldUsing($using);

        $using = json_encode($using);

        AssertEquals::applyWith(
            true,
            HasMembers::applyWith("second")
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            false,
            HasMembers::applyWith("third")
        )->unfoldUsing($using);
    }
}
