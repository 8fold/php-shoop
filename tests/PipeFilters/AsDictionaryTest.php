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

class AsDictionaryTest extends TestCase
{
    public function test_from_array()
    {
        $payload = [0, 1];

        $this->start = hrtime(true);
        $expected = ["i0" => 0, "i1" => 1];
        $actual   = Shoop::pipe($payload, AsDictionary::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.7);

        $this->start = hrtime(true);
        $expected = $expected;
        $actual   = Shoop::pipe($payload, FromArray::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_bool()
    {
        $payload = true;
        $expected = ["true" => true, "false" => false];
        $actual = Shoop::pipe($payload, AsDictionary::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $payload = false;
        $expected = ["true" => false, "false" => true];
        $actual = Shoop::pipe($payload, FromBool::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_dictionary()
    {
        $payload = ["true" => true, "false" => false];

        $expected = $payload;
        $actual = Shoop::pipe($payload, AsDictionary::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_int()
    {
        $payload = 2;

        $expected = ["i0" => 0, "i1" => 1, "i2" => 2];
        $actual = Shoop::pipe($payload, AsDictionary::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = ["i0" => 0, "i1" => 1, "i2" => 2];
        $actual = Shoop::pipe($payload, FromInt::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = ["i0" => 1, "i1" => 2];
        $actual = Shoop::pipe($payload, AsDictionary::applyWith(1))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = ["i0" => 1, "i1" => 2];
        $actual = Shoop::pipe($payload, FromInt::applyWith(1))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_json()
    {
        $payload = '{"member":false}';

        $expected = ["member" => false];
        $actual = Shoop::pipe($payload, AsDictionary::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = ["member" => false];
        $actual = Shoop::pipe($payload, FromJson::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_object()
    {
        $payload = new stdClass;
        $payload->member = false;

        $expected = ["member" => false];
        $actual = Shoop::pipe($payload, AsDictionary::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = ["member" => false];
        $actual = Shoop::pipe($payload, FromObject::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_string()
    {
        // TODO: Discuss what should happen when a string becomes a dictionary.
        //      Setting member "string" with it as the value.
        $payload = "payload";
        $expected = ["string" => "payload"];
        $actual = Shoop::pipe($payload, AsDictionary::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $actual = Shoop::pipe($payload, FromString::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}
