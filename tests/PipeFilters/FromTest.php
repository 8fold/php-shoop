<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;

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
    public function span_from_lists()
    {
        $using = [3, 2, 5, 4];

        $this->start = hrtime(true);
        $expected = [3, 2, 5, 4];

        $actual = From::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 1);

        $this->start = hrtime(true);
        $expected = [5, 4];

        $actual = From::applyWith(-2)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 0.75);

        $using = ["a" => 1, "b" => 2, "c" => 3, "d" => 4];

        $this->start = hrtime(true);
        $expected = ["b" => 2, "c" => 3];

        $actual = From::applyWith(1, 2)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function span_within_string()
    {
        $using = "So, raise your glass!";

        $this->start = hrtime(true);
        $expected = "raise";

        $actual = From::applyWith(4, 5)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 4.75);

        $using = '{"member":true,"member2":false}';

        $this->start = hrtime(true);
        $expected = '{"member2":false}';

        $actual = From::applyWith(1, 1)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 4.45);
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
