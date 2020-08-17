<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\PipeFilters\PullRange;
use Eightfold\Shoop\PipeFilters\PullFirst;

/**
 * @group Pull
 */
class PullTest extends TestCase
{
    /**
     * @test
     */
    public function pull_range_of_content_from_list_type()
    {
        $using = [3, 2, 5, 4];

        $this->start = hrtime(true);
        $expected = [3, 2, 5, 4];

        $actual = PullRange::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 0.85);

        $this->start = hrtime(true);
        $expected = [5, 4];

        $actual = PullRange::applyWith(-2)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 0.75);

        $using = ["a" => 1, "b" => 2, "c" => 3, "d" => 4];

        $this->start = hrtime(true);
        $expected = ["b" => 2, "c" => 3];

        $actual = PullRange::applyWith(1, 2)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function pull_range_of_content_from_string()
    {
        $using = "So, raise your glass!";

        $this->start = hrtime(true);
        $expected = "raise";

        $actual = PullRange::applyWith(4, 5)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 1.7);
    }

    /**
     * @test
     *
     * TODO: Maybe this should return boolean - running into stack overflow when
     *     attempting. Not used often - skipping for now.
     */
    public function pull_range_from_boolean_allows_invalid_index()
    {
        $using = true;

        $this->start = hrtime(true);
        $expected = ["false" => false];

        $actual = PullRange::applyWith(1, 5)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = [];

        $actual = PullRange::applyWith(3, 20)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function uses_string_members()
    {
        $using = new class {
            public $public = "content";
            public $public2 = 2;
            public $public3 = false;
        };

        $this->start = hrtime(true);
        $expected = ["public2" => 2];

        $actual = PullRange::applyWith(1, 1)->unfoldUsing($using);
    }
}
