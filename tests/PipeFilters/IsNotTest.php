<?php

namespace Eightfold\Shoop\Tests\Replace\Php;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\IsNot;

class IsNotTest extends TestCase
{
    public function test_from_array()
    {
        $using = [0, 1, 2, 3];

        $expected = false;
        $actual   = Shoop::pipe($using, IsNot::applyWith([0, 1, 2, 3]))
            ->unfold();
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
