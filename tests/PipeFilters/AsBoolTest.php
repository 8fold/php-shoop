<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\AsBool;
use Eightfold\Shoop\PipeFilters\AsBool\FromArray;

class AsBoolTest extends TestCase
{
    public function test_from_array()
    {
        $payload = [0, 1, 2, 3];

        // $expected = true;
        // $actual   = Shoop::pipe($payload, AsBool::apply())->unfold();
        // $this->assertEqualsWithPerformance($expected, $actual);

        $expected = true;
        $actual   = Shoop::pipe($payload, FromArray::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_bool()
    {
    }

    public function test_from_dictionary()
    {
    }

    public function test_from_int()
    {
    }

    public function test_from_json()
    {
    }

    public function test_from_object()
    {
    }

    public function test_from_string()
    {
    }
}
