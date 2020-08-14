<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\AsString;
use Eightfold\Shoop\PipeFilters\AsString\FromArray;
use Eightfold\Shoop\PipeFilters\AsString\FromBool;
use Eightfold\Shoop\PipeFilters\AsString\FromInteger;
use Eightfold\Shoop\PipeFilters\AsString\FromJson;
use Eightfold\Shoop\PipeFilters\AsString\FromObject;
use Eightfold\Shoop\PipeFilters\AsString\FromString;

/**
 * @group AsString
 */
class AsStringTestSuite extends TestCase
{
    public function test_from_array()
    {
        $using = ["8", "fold"];

        $this->start = hrtime(true);
        $expected = "8fold";
        $actual = Shoop::pipe($using, AsString::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.8);

        $this->start = hrtime(true);
        $expected = "8!fold";
        $actual = Shoop::pipe($using, AsString::applyWith("!"))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = "8!fold";
        $actual = Shoop::pipe($using, FromArray::applyWith("!"))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_bool()
    {
        $using = true;
        $expected = "true";
        $actual = Shoop::pipe($using, AsString::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = false;
        $expected = "false";
        $actual = Shoop::pipe($using, FromBool::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_dictionary()
    {
        $using = ["a" => "8", "b" => true, "c" => "fold", "d" => 0];

        $this->start = hrtime(true);
        $expected = "8fold";
        $actual = Shoop::pipe($using, AsString::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.8);

        $this->start = hrtime(true);
        $expected = "8!fold";
        $actual = Shoop::pipe($using, AsString::applyWith("!"))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = "8!fold";
        $actual = Shoop::pipe($using, FromArray::applyWith("!"))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_int()
    {
        $using = 0;

        $expected = "0";
        $actual = Shoop::pipe($using, AsString::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = "0";
        $actual = Shoop::pipe($using, FromInteger::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_json()
    {
    }

    public function test_from_object()
    {
        $using = new stdClass;
        $using->member  = "8";
        $using->member2 = 8;
        $using->member3 = false;
        $using->member4 = "f";
        $using->member5 = "old";

        $expected = "8fold";
        $actual = Shoop::pipe($using, AsString::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = "8!f!old";
        $actual = Shoop::pipe($using, AsString::applyWith("!"))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_string()
    {
    }
}
