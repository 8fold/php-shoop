<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;
use Eightfold\Shoop\Tests\AssertEquals;

use \stdClass;

use Eightfold\Shoop\PipeFilters\From;

/**
 * @group From
 */
class FromTest extends TestCase
{
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
            0.8
        )->unfoldUsing("So, raise your glass!");

        AssertEquals::applyWith(
            '{"member2":false}',
            From::applyWith(1, 1)
        )->unfoldUsing('{"member":true,"member2":false}');
    }

    /**
     * @test
     *
     * TODO: Maybe this should return boolean - running into stack overflow when
     *     attempting. Not used often - skipping for now.
     */
    public function span_from_boolean_allows_invalid_index()
    {
        $using = true;

        $this->start = hrtime(true);
        $expected = true;

        $actual = From::applyWith(1, 5)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 0.9);

        $using = false;

        $this->start = hrtime(true);
        $expected = false;

        $actual = From::applyWith(3, 20)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     *
     * @group content
     */
    public function span_from_tuples()
    {
        $using = new class {
            public $public = "content";
            public $public2 = 2;
            public $public3 = false;
        };

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->public2 = 2;

        $actual = From::applyWith(1, 1)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 1.65);
    }

    public function span_first()
    {
        $using = "Life is ours and we live it our way.";

        $this->start = hrtime(true);
        $expected = "Life";

        $actual = From::applyWith(5)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 3.65);
    }

    public function span_last()
    {
        $using = "Life is ours and we live it our way.";

        $this->start = hrtime(true);
        $expected = "way";

        $actual = PullFirst::applyWith(-1, -3)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 3.65);
    }
}
