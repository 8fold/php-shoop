<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\AsInt;
use Eightfold\Shoop\PipeFilters\AsInt\FromArray;
use Eightfold\Shoop\PipeFilters\AsInt\FromBool;
use Eightfold\Shoop\PipeFilters\AsInt\FromJson;
use Eightfold\Shoop\PipeFilters\AsInt\FromObject;
use Eightfold\Shoop\PipeFilters\AsInt\FromString;

class AsIntTest extends TestCase
{
    public function test_from_array()
    {
        $payload = [0, 1, 2, 3];

        $expected = 4;
        $actual   = Shoop::pipe($payload, AsInt::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.5);

        $this->start = hrtime(true);
        $expected = 4;
        $actual   = Shoop::pipe($payload, FromArray::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_bool()
    {
        $payload = true;

        $expected = 1;
        $actual = Shoop::pipe($payload, AsInt::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = 1;
        $actual = Shoop::pipe($payload, FromBool::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $payload = false;
        $expected = 0;
        $actual = Shoop::pipe($payload, FromBool::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_dictionary()
    {
        $payload = ["a" => 0, "b" => 1];

        $expected = 2;
        $actual   = Shoop::pipe($payload, AsInt::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.2);

        $this->start = hrtime(true);
        $expected = 2;
        $actual   = Shoop::pipe($payload, FromArray::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_int()
    {
        $payload = 100;

        $expected = 100;
        $actual = Shoop::pipe($payload, AsInt::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_json()
    {
        $payload = '{"member":true}';

        $expected = 1;
        $actual = Shoop::pipe($payload, AsInt::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = 1;
        $actual = Shoop::pipe($payload, FromJson::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_object()
    {
        $payload = new \stdClass;
        $payload->member = "hello";

        $expected = 1;
        $actual = Shoop::pipe($payload, AsInt::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = 1;
        $actual = Shoop::pipe($payload, FromObject::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_string()
    {
        $payload = "8fold";

        $expected = 5;
        $actual = Shoop::pipe($payload, AsInt::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.5);

        $expected = 5;
        $actual = Shoop::pipe($payload, FromString::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}
