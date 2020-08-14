<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\AsObject;
use Eightfold\Shoop\PipeFilters\AsObject\FromArray;
use Eightfold\Shoop\PipeFilters\AsObject\FromBool;
use Eightfold\Shoop\PipeFilters\AsObject\FromDictionary;
use Eightfold\Shoop\PipeFilters\AsObject\FromInt;
use Eightfold\Shoop\PipeFilters\AsObject\FromJson;
use Eightfold\Shoop\PipeFilters\AsObject\FromString;

class AsObjectTest extends TestCase
{
    public function test_from_array()
    {
        $payload = [0];

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->i0 = 0;
        $actual   = Shoop::pipe($payload, AsObject::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.7);

        $this->start = hrtime(true);
        $actual = Shoop::pipe($payload, FromArray::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_bool()
    {
        $payload = true;

        $expected = new stdClass;
        $expected->true = true;
        $expected->false = false;
        $actual = Shoop::pipe($payload, AsObject::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $actual = Shoop::pipe($payload, FromBool::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_dictionary()
    {
        $payload = ["true" => false];

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->true = false;
        $actual = Shoop::pipe($payload, AsObject::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.2);

        $this->start = hrtime(true);
        $actual = Shoop::pipe($payload, FromDictionary::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_int()
    {
        $payload = 0;
        $expected = new stdClass;
        $expected->i0 = 0;
        $actual = Shoop::pipe($payload, AsObject::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $payload = 1;
        $expected = new stdClass;
        $expected->i0 = 1;
        $actual = Shoop::pipe($payload, FromInt::applyWith(1))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $payload = -3;
        $expected = new stdClass;
        $expected->i0 = -3;
        $expected->i1 = -2;
        $expected->i2 = -1;
        $expected->i3 = 0;
        $actual = Shoop::pipe($payload, FromInt::applyWith(0))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_json()
    {
        $payload = '{}';
        $expected = new stdClass;
        $actual = Shoop::pipe($payload, AsObject::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 0.85);

        $payload = '{"member":false}';
        $expected->member = false;
        $actual = Shoop::pipe($payload, FromJson::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_object()
    {
        $payload = new stdClass;
        $payload->hello = "hello again";

        $expected = $payload;
        $actual = Shoop::pipe($payload, AsObject::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_string()
    {
        $payload = "";

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->string = "";
        $actual = Shoop::pipe($payload, AsObject::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $actual = Shoop::pipe($payload, FromString::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}
