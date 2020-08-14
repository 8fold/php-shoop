<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\PipeFilters\AsArray;

/**
 * @group AsArray
 */
class AsArrayTestSuite extends TestCase
{
    /**
     * @test
     */
    public function array_to_array_results_in_same_array()
    {
        $this->start = hrtime(true);
        $using = [1, 2, 3];
        $expected = $using;
        $actual = AsArray::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 1.1);
    }

    /**
     * @test
     */
    public function bool_to_array_has_bool_as_array_content()
    {
        $using = true;

        $expected = [$using];
        $actual = AsArray::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function dictionary_to_array_has_sequential_numeric_indeces()
    {
        $using = ["0" => 1, "hello" => 2, 8 => 3];

        $expected = [0 => 1, 1 => 2, 2 => 3];
        $actual = AsArray::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function integer_to_array_generates_range_from_zero_or_start()
    {
        $using = 4;

        $expected = [0, 1, 2, 3, 4];
        $actual = AsArray::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = [3, 4];
        $actual = AsArray::applyWith(3)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function json_to_array_has_sequential_numeric_indeces()
    {
        $using = '{"member":true}';

        $expected = [true];
        $actual = AsArray::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function object_to_array_has_sequential_numeric_indeces()
    {
        $using = new stdClass;
        $using->member = true;

        $expected = [true];
        $actual = AsArray::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function string_to_array_separates_letters_using_numeric_indeces()
    {
        $using = "8fold";

        $expected = ["8", "f", "o", "l", "d"];
        $actual = AsArray::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function string_accepts_specified_dividing_character()
    {
        $using = "I remember. A long time ago.";

        $expected = ["I", "remember.", "A", "long", "time", "ago."];
        $actual = AsArray::applyWith(" ")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function string_includes_empty_content_by_default()
    {
        $using = " I remember. A... ";

        $expected = ["", "I", "remember.", "A...", ""];
        $actual = AsArray::applyWith(" ")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = ["I", "remember.", "A..."];
        $actual = AsArray::applyWith(" ", false)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function string_limiting_item_count()
    {
        $using = "I remember. A long time ago.";

        $expected = ["I", "remember.", "A long time ago."];
        $actual = AsArray::applyWith(" ", false, 3)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}
