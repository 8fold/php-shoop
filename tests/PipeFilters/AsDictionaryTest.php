<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\AsDictionary;
use Eightfold\Shoop\PipeFilters\AsDictionary\FromArray;
use Eightfold\Shoop\PipeFilters\AsDictionary\FromBool;
use Eightfold\Shoop\PipeFilters\AsDictionary\FromInt;
use Eightfold\Shoop\PipeFilters\AsDictionary\FromJson;
use Eightfold\Shoop\PipeFilters\AsDictionary\FromObject;
use Eightfold\Shoop\PipeFilters\AsDictionary\FromString;

/**
 * @group AsDictionary
 */
class AsDictionaryTestSuite extends TestCase
{
    public function test_from_array()
    {
        $using = [0, 1];

        $this->start = hrtime(true);
        $expected = ["i0" => 0, "i1" => 1];
        $actual   = Shoop::pipe($using, AsDictionary::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.7);

        $this->start = hrtime(true);
        $expected = $expected;
        $actual   = Shoop::pipe($using, FromArray::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_bool()
    {
        $using = true;
        $expected = ["true" => true, "false" => false];
        $actual = Shoop::pipe($using, AsDictionary::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = false;
        $expected = ["true" => false, "false" => true];
        $actual = Shoop::pipe($using, FromBool::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_dictionary()
    {
        $using = ["true" => true, "false" => false];

        $expected = $using;
        $actual = Shoop::pipe($using, AsDictionary::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_int()
    {
        $using = 2;

        $expected = ["i0" => 0, "i1" => 1, "i2" => 2];
        $actual = Shoop::pipe($using, AsDictionary::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = ["i0" => 0, "i1" => 1, "i2" => 2];
        $actual = Shoop::pipe($using, FromInt::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = ["i0" => 1, "i1" => 2];
        $actual = Shoop::pipe($using, AsDictionary::applyWith(1))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = ["i0" => 1, "i1" => 2];
        $actual = Shoop::pipe($using, FromInt::applyWith(1))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_json()
    {
        $using = '{"member":false}';

        $expected = ["member" => false];
        $actual = Shoop::pipe($using, AsDictionary::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = ["member" => false];
        $actual = Shoop::pipe($using, FromJson::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_object()
    {
        $using = new stdClass;
        $using->member = false;

        $expected = ["member" => false];
        $actual = Shoop::pipe($using, AsDictionary::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = ["member" => false];
        $actual = Shoop::pipe($using, FromObject::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_string()
    {
        // TODO: Discuss what should happen when a string becomes a dictionary.
        //      Setting member "string" with it as the value.
        $using = "payload";
        $expected = ["string" => "payload"];
        $actual = Shoop::pipe($using, AsDictionary::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $actual = Shoop::pipe($using, FromString::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}
