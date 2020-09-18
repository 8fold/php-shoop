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
            [false, true],
            "array",
            2.23, // 1.18, // 0.66, // 0.61, // 0.6, // 0.42, // 0.34
            88 // 83
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
            false,
            "boolean"
        )->unfoldUsing(
            From::applyWith(0, 1)->unfoldUsing(true) // uses array
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
            [2, 3],
            "array",
            0.34
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
            [2, false],
            "array",
            1.23,
            72
        )->unfoldUsing(
            From::applyWith(1, 2)->unfoldUsing($using)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            1.44, // 1.37, // 1.33, // 0.88 // 0.59
            83
        )->unfoldUsing(
            From::applyWith(1, 1)->unfoldUsing('{"member":true,"member2":false}')
        );
    }
}
