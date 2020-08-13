<?php

namespace Eightfold\Shoop\Tests\Replace\Php;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\First;

class AsArrayTest extends TestCase
{
    public function test_from_array()
    {
        $payload = [0, 1, 2, 3];

        $expected = $payload;
        $actual   = Shoop::pipe($payload, AsArray::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $payload = [1 => 1, 0 => 0, 3 => 3, 2 => 2];
        $expected = [1, 0, 3, 2];
        $actual   = Shoop::pipe($payload, AsArray::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_bool()
    {
    }

    public function test_from_dictionary()
    {
    }

    public function test_from_json()
    {
    }

    public function test_from_int()
    {
    }

    public function test_from_object()
    {
    }

    public function test_from_string()
    {
    }
}
