<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\AsBool;
use Eightfold\Shoop\PipeFilters\AsBool\FromArray;
use Eightfold\Shoop\PipeFilters\AsBool\FromInt;
use Eightfold\Shoop\PipeFilters\AsBool\FromJson;
use Eightfold\Shoop\PipeFilters\AsBool\FromObject;
use Eightfold\Shoop\PipeFilters\AsBool\FromString;

/**
 * @group AsBool
 */
class AsBoolTestSuite extends TestCase
{
    public function test_from_array()
    {
        $using = [0, 1, 2, 3];

        $this->start = hrtime(true);
        $expected = true;
        $actual   = Shoop::pipe($using, AsBool::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 2.05);

        $this->start = hrtime(true);
        $expected = true;
        $actual   = Shoop::pipe($using, FromArray::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_bool()
    {
        $using = true;
        $expected = true;
        $actual = Shoop::pipe($using, AsBool::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_dictionary()
    {
        $using = ["true" => false];

        $expected = true;
        $actual = Shoop::pipe($using, AsBool::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $actual = Shoop::pipe($using, FromArray::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_int()
    {
        $using = 0;
        $expected = false;
        $actual = Shoop::pipe($using, AsBool::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = 100;
        $expected = true;
        $actual = Shoop::pipe($using, FromInt::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = -3;
        $expected = true;
        $actual = Shoop::pipe($using, FromInt::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_json()
    {
        // TODO: Should an empty JSON object return false
        //      how close should empty and bool be??
        $this->start = hrtime(true);
        $using = '{}';
        $expected = true;//false
        $actual = Shoop::pipe($using, AsBool::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 0.85);

        $this->start = hrtime(true);
        $using = '{"member":false}';
        $expected = true;
        $actual = Shoop::pipe($using, FromJson::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_object()
    {
        // TODO: Should an empty object return false
        //      how close should empty and bool be??
        //      we did say that an empty array is a
        //      ditionary because it could become one
        $using = new stdClass;
        $expected = true;// false
        $actual = Shoop::pipe($using, AsBool::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $using->member = false;
        $expected = true;
        $actual = Shoop::pipe($using, FromObject::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_string()
    {
        $using = "";
        $expected = false;
        $actual = Shoop::pipe($using, AsBool::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        // TODO: Should we convert the strings of "true" and "false"
        //      directly?? Basically, as long as the string is not
        //      empty, it is considered true by PHP type juggling.
        $using = "false";
        $expected = true; // false
        $actual = Shoop::pipe($using, FromString::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}
