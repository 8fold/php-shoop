<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Filter\Members;

/**
 * @group Members
 */
class MembersTest extends TestCase
{
    /**
     * @test
     */
    public function boolean()
    {
        AssertEquals::applyWith(
            ["false", "true"],
            "array",
            0.83, // 0.72
            59
        )->unfoldUsing(
            Members::apply()->unfoldUsing(false)
        );
    }

    /**
     * @test
     */
    public function lists()
    {
        $using = [3, 2, 5, 4];

        AssertEquals::applyWith(
            [0, 1, 2, 3],
            "array",
            0.69, // 0.59,
            44
        )->unfoldUsing(
            Members::apply()->unfoldUsing($using)
        );

        AssertEquals::applyWith(
            ["a", "b", "c", "d"],
            "array"
        )->unfoldUsing(
            Members::apply()->unfoldUsing(["a" => 1, "b" => 2, "c" => 3, "d" => 4])
        );
    }

    /**
     * @test
     */
    public function strings()
    {
        AssertEquals::applyWith(
            [0, 1, 2, 3, 4, 5],
            "array",
            0.94, // 0.9
            63
        )->unfoldUsing(
            Members::apply()->unfoldUsing("8fold!")
        );
    }

    /**
     * @test
     */
    public function tuples()
    {
        $using = new class {
            public $public = "content";
            public $public2 = 2;
            public $public3 = false;
        };

        AssertEquals::applyWith(
            ["public", "public2", "public3"],
            "array",
            0.93, // 0.87, // 0.83, // 0.77,
            59
        )->unfoldUsing(
            Members::apply()->unfoldUsing($using)
        );

        AssertEquals::applyWith(
            ["member", "member2"],
            "array",
            0.3,
            12
        )->unfoldUsing(
            Members::apply()->unfoldUsing('{"member":true,"member2":false}')
        );
    }
}
