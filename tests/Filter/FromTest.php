<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestClasses\TestCase;
use Eightfold\Shoop\Tests\TestClasses\AssertEquals;

use \stdClass;

use Eightfold\Shoop\Filter\From;

/**
 * @group From
 */
class FromTest extends TestCase
{
    /**
     * @test
     */
    public function boolean()
    {
        AssertEquals::applyWith(
            false,
            From::apply(),
            2.71
        )->unfoldUsing(true);

        AssertEquals::applyWith(
            true,
            From::applyWith(1) // uses array
        )->unfoldUsing(true);

        AssertEquals::applyWith(
            true,
            From::applyWith("false"), // uses dictionary
            0.31
        )->unfoldUsing(false);
    }

    /**
     * @test
     */
    public function lists()
    {
        $using = [3, 2, 5, 4];

        AssertEquals::applyWith(
            [3, 2, 5, 4],
            From::apply(),
            0.3
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            [5, 4],
            From::applyWith(-2),
            0.35
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            ["b" => 2, "c" => 3],
            From::applyWith(1, 2),
            0.35
        )->unfoldUsing(["a" => 1, "b" => 2, "c" => 3, "d" => 4]);
    }

    /**
     * @test
     */
    public function strings()
    {
        AssertEquals::applyWith(
            "raise",
            From::applyWith(4, 5),
            3.64
        )->unfoldUsing("So, raise your glass!");

        $using = "Life is ours and we live it our way.";

        AssertEquals::applyWith(
            "Life",
            From::applyWith(0, 4)
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            "way",
            From::applyWith(-4, 3)
        )->unfoldUsing($using);
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
            (object) ["public" => "content", "public2" => 2, "public3" => false],
            From::applyWith(1, 1),
            1.35
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            '{"member2":false}',
            From::applyWith(1, 1),
            1.19
        )->unfoldUsing('{"member":true,"member2":false}');
    }
}
