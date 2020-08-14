<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\PullFirst;
use Eightfold\Shoop\PipeFilters\PullFirst\FromArray;
use Eightfold\Shoop\PipeFilters\PullFirst\FromInt;
use Eightfold\Shoop\PipeFilters\PullFirst\FromJson;
use Eightfold\Shoop\PipeFilters\PullFirst\FromObject;
use Eightfold\Shoop\PipeFilters\PullFirst\FromString;

class FirstTest extends TestCase
{
    public function test_from_array()
    {
        $using = [3, 2, 5, 4];

        $this->start = hrtime(true);
        $expected = [3];
        $actual   = Shoop::pipe($using, PullFirst::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.05);

        $this->start = hrtime(true);
        $expected = [3, 2];
        $actual   = Shoop::pipe($using, FromArray::applyWith(2))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_bool()
    {
        $this->assertFalse(false);
    }

    public function test_from_dictionary()
    {
        $using = ["a" => 3, "b" => 2, "c" => 5, "d" => 4];

        $expected = ["a" => 3];
        $actual   = Shoop::pipe($using, PullFirst::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = ["a" => 3, "b" => 2];
        $actual   = Shoop::pipe($using, FromArray::applyWith(2))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_int()
    {
        $using = 5;

        $expected = [1, 2];
        $actual = Shoop::pipe($using, PullFirst::applyWith(2, 1))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = [4, 5];
        $actual = Shoop::pipe($using, FromInt::applyWith(5, 4))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_json()
    {
        $using = '{}';

        $expected = [];
        $actual = Shoop::pipe($using, PullFirst::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = [];
        $actual = Shoop::pipe($using, FromJson::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_object()
    {
        $using = new stdClass;
        $using->first = 1;
        $using->second = "8fold";

        $expected = ["first" => 1];
        $actual = Shoop::pipe($using, PullFirst::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = ["first" => 1, "second" => "8fold"];
        $actual = Shoop::pipe($using, FromObject::applyWith(2))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_string()
    {
        $using = "8fold?";

        $this->start = hrtime(true);
        $expected = "8";
        $actual = Shoop::pipe($using, PullFirst::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 0.7);

        $expected = "8fold";
        $actual = Shoop::pipe($using, FromString::applyWith(5))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}
