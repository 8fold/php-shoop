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
        $this->assertEqualsWithPerformance($expected, $actual, 0.7);

        $this->start = hrtime(true);
        $expected = [5, 4];

        $actual = PullRange::applyWith(-2)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 0.75);
    }

    // /**
    //  * @test
    //  */
    // public function from_bool__invalid_length_does_not_error()
    // {
    //     $using = true;

    //     $expected = [true];

    //     $actual = PullFirst::applyWith(3)->unfoldUsing($using);
    //     $this->assertEqualsWithPerformance($expected, $actual, 4.65);
    // }

    // /**
    //  * @test
    //  */
    // public function from_int__can_specifying_starting_position()
    // {
    //     $using = 5;

    //     $this->start = hrtime(true);
    //     $expected = [1, 2];
    //     $actual = PullFirst::applyWith(2, 1)->unfoldUsing($using);
    //     $this->assertEqualsWithPerformance($expected, $actual, 1.1);
    // }

    // /**
    //  * @test
    //  */
    // public function from_string_defaults_to_array_without_other_options_available()
    // {
    //     $using = "8fold?";

    //     $this->start = hrtime(true);
    //     $expected = ["8"];

    //     $actual = PullFirst::apply()->unfoldUsing($using);
    //     $this->assertEqualsWithPerformance($expected, $actual, 0.7);
    // }

    // /**
    //  * @test
    //  */
    // public function from_dictionary__maintains_named_members()
    // {
    //     $using = ["a" => 3, "b" => 2, "c" => 5, "d" => 4];

    //     $this->start = hrtime(true);
    //     $expected = ["b" => 2, "c" => 5, "d" => 4];

    //     $actual = PullFirst::applyWith(3, 1)->unfoldUsing($using);
    //     $this->assertEqualsWithPerformance($expected, $actual);
    // }

    // /**
    //  * @test
    //  */
    // public function from_json__empty_does_not_cause_halt()
    // {
    //     $using = '{}';

    //     $expected = [];

    //     $actual = PullFirst::applyWith(8)->unfoldUsing($using);
    //     $this->assertEqualsWithPerformance($expected, $actual, 3.35);
    // }

    // /**
    //  * @test
    //  */
    // public function from_object()
    // {
    //     $using = new class {
    //         public $first = 1;
    //         public $second = "8fold";
    //         private $null;
    //         private $default = "";
    //     };

    //     $expected = ["second" => "8fold"];

    //     $actual = PullFirst::applyWith(2, 1)->unfoldUsing($using);
    //     $this->assertEqualsWithPerformance($expected, $actual, 2);
    // }

    // /**
    //  * @test
    //  */
    // public function always_from_start_even_when_length_is_negative()
    // {
    //     $using = [3, 2, 5, 4];

    //     $this->start = hrtime(true);
    //     $expected = [3, 2];

    //     $actual = PullFirst::applyWith(-2)->unfoldUsing($using);
    //     $this->assertEqualsWithPerformance($expected, $actual, 3.9);
    // }
}
