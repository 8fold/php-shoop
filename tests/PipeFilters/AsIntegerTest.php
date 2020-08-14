<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\AsInteger;
use Eightfold\Shoop\PipeFilters\AsInteger\FromArray;
use Eightfold\Shoop\PipeFilters\AsInteger\FromBool;
use Eightfold\Shoop\PipeFilters\AsInteger\FromJson;
use Eightfold\Shoop\PipeFilters\AsInteger\FromObject;
use Eightfold\Shoop\PipeFilters\AsInteger\FromString;

/**
 * @group AsInteger
 */
class AsIntegerTestSuite extends TestCase
{
    public function test_from_array()
    {
        $using = [0, 1, 2, 3];

        $expected = 4;
        $actual   = Shoop::pipe($using, AsInteger::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.5);

        $this->start = hrtime(true);
        $expected = 4;
        $actual   = Shoop::pipe($using, FromArray::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_bool()
    {
        $using = true;

        $expected = 1;
        $actual = Shoop::pipe($using, AsInteger::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = 1;
        $actual = Shoop::pipe($using, FromBool::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = false;
        $expected = 0;
        $actual = Shoop::pipe($using, FromBool::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_dictionary()
    {
        $using = ["a" => 0, "b" => 1];

        $expected = 2;
        $actual   = Shoop::pipe($using, AsInteger::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.2);

        $this->start = hrtime(true);
        $expected = 2;
        $actual   = Shoop::pipe($using, FromArray::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_int()
    {
        $using = 100;

        $expected = 100;
        $actual = Shoop::pipe($using, AsInteger::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_json()
    {
        $using = '{"member":true}';

        $expected = 1;
        $actual = Shoop::pipe($using, AsInteger::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 0.75);

        $this->start = hrtime(true);
        $expected = 1;
        $actual = Shoop::pipe($using, FromJson::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_object()
    {
        $using = new \stdClass;
        $using->member = "hello";

        $expected = 1;
        $actual = Shoop::pipe($using, AsInteger::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = 1;
        $actual = Shoop::pipe($using, FromObject::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_string()
    {
        $using = "8fold";

        $expected = 5;
        $actual = Shoop::pipe($using, AsInteger::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.5);

        $this->start = hrtime(true);
        $expected = 5;
        $actual = Shoop::pipe($using, FromString::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = "I remember. A long time ago.";

        $expected = 1;
        $actual = Shoop::pipe($using, AsInteger::applyWith(false, "I"))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = 1;
        $actual = Shoop::pipe($using, FromString::applyWith(false, "i"))
            ->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = 2;
        $actual = Shoop::pipe($using, AsInteger::applyWith(false, "a", false)
            )->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 0.9);

        $expected = 2;
        $actual = Shoop::pipe($using, FromString::applyWith(false, "A", false)
            )->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $using = "8";

        $expected = 8;
        $actual = Shoop::pipe($using, AsInteger::applyWith(true))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.5);

        $expected = 8;
        $actual = Shoop::pipe($using, FromString::applyWith(true))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}
