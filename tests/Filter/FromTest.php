<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

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
            "boolean",
            3.07,
            97 // 33
        )->unfoldUsing(
            From::apply()->unfoldUsing(true)
        );

        AssertEquals::applyWith(
            true,
            "boolean"
        )->unfoldUsing(
            From::applyWith(1)->unfoldUsing(true) // uses array
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.48,
            11
        )->unfoldUsing(
            From::applyWith("false")->unfoldUsing(false) // uses dictionary
        );
    }

    /**
     * @test
     */
    public function lists()
    {
        $using = [3, 2, 5, 4];

        AssertEquals::applyWith(
            [3, 2, 5, 4],
            "array",
            0.35
        )->unfoldUsing(
            From::apply()->unfoldUsing($using)
        );

        AssertEquals::applyWith(
            [5, 4],
            "array"
        )->unfoldUsing(
            From::applyWith(-2)->unfoldUsing($using)
        );

        AssertEquals::applyWith(
            ["b" => 2, "c" => 3],
            "array"
        )->unfoldUsing(
            From::applyWith(1, 2)->unfoldUsing(["a" => 1, "b" => 2, "c" => 3, "d" => 4])
        );
    }

    /**
     * @test
     */
    public function strings()
    {
        AssertEquals::applyWith(
            "raise",
            "string"
        )->unfoldUsing(
            From::applyWith(4, 5)->unfoldUsing("So, raise your glass!")
        );

        $using = "Life is ours and we live it our way.";

        AssertEquals::applyWith(
            "Life",
            "string"
        )->unfoldUsing(
            From::applyWith(0, 4)->unfoldUsing($using)
        );

        AssertEquals::applyWith(
            "way",
            "string"
        )->unfoldUsing(
            From::applyWith(-4, 3)->unfoldUsing($using)
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
            (object) ["public2" => 2],
            "object",
            2.76,
            24
        )->unfoldUsing(
            From::applyWith(1, 1)->unfoldUsing($using)
        );

        AssertEquals::applyWith(
            '{"member2":false}',
            "string",
            0.59
        )->unfoldUsing(
            From::applyWith(1, 1)->unfoldUsing('{"member":true,"member2":false}')
        );
    }
}
