<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsTuple;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsDictionary;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsInteger;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsNumber;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsBoolean;

/**
 * @group PhpDeviations
 */
class PhpDeviationsTest extends TestCase
{
    /**
     * @test
     */
    public function all_to_integer_results_in_element_count()
    {
        // chars in string
        // indeces in array
        // properties in tuple
        // same number if number
    }

    /**
     * @test
     */
    public function boolean_to_dictionary_affords_access_to_true_and_false_values()
    {
    }

    /**
     * @test
     */
    public function array_to_string_conversion_possible_with_options()
    {
    }

    /**
     * @test
     */
    public function string_to_array_conversion_possible_with_options()
    {
    }

    /**
     * @test
     */
    public function integer_to_array_becomes_range()
    {
    }

    /**
     * @test
     */
    public function empty_php_array_is_empty_dictionary()
    {
    }

    /**
     * @test
     */
    public function dictionary_keys_must_be_strings()
    {
        // if prefix set - use prefix
        // if not, item is not part of dictionary
    }

    /**
     * @test
     *
     * TODO: Does PHP allow for a class that uses __invoke, is it only closures
     */
    public function dictionary_and_array_cannot_contain_callable()
    {
    }

    /**
     * @test
     */
    public function boolean_is_directly_castable_from_numbers_only()
    {
        // 0 = false
        // all others = true
    }

    /**
     * @test
     */
    public function array_must_use_integer_keys_in_sequence_base_is_assignable()
    {
    }
}
