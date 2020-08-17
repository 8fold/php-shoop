<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\PipeFilters\PullRange;
use Eightfold\Shoop\PipeFilters\PullFirst;
use Eightfold\Shoop\PipeFilters\PullLast;

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

    /**
     * @test
     */
    public function pull_range_of_types_using_string_members()
    {
        $using = new class {
            public $public = "content";
            public $public2 = 2;
            public $public3 = false;
        };

        $this->start = hrtime(true);
        $expected = ["public2" => 2];

        $actual = PullRange::applyWith(1, 1)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function pull_first()
    {
        $using = "Life is ours and we live it our way.";

        $this->start = hrtime(true);
        $expected = "Life";

        $actual = PullFirst::applyWith(5)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 3.65);
    }

    /**
     * @test
     */
    public function pull_last__from_object_juggle()
    {
        $using = new class {
            public $z = true;
            public $y;
            public $x;

            public function __construct()
            {
                $this->y = PullFirst::apply();
                $this->x = function() { return "x"; };
            }
        };

        $this->start = hrtime(true);
        $expected = ["y" => PullFirst::apply()];

        $actual = PullLast::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 2);
    }
}
