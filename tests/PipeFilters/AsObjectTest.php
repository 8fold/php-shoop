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

/**
 * @group AsObject
 */
class AsObjectTestSuite extends TestCase
{
    public function test_from_array()
    {
        $using = [0];

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->i0 = 0;
        $actual   = Shoop::pipe($using, AsObject::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.7);

        $this->start = hrtime(true);
        $actual = Shoop::pipe($using, FromArray::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_bool()
    {
        $using = true;

        $expected = new stdClass;
        $expected->true = true;
        $expected->false = false;
        $actual = Shoop::pipe($using, AsObject::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $actual = Shoop::pipe($using, FromBool::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_dictionary()
    {
        $using = ["true" => false];

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->true = false;
        $actual = Shoop::pipe($using, AsObject::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.2);

        $this->start = hrtime(true);
        $actual = Shoop::pipe($using, FromDictionary::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_int()
    {
        $using = 0;
        $expected = new stdClass;
        $expected->i0 = 0;
        $actual = Shoop::pipe($using, AsObject::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = 1;
        $expected = new stdClass;
        $expected->i0 = 1;
        $actual = Shoop::pipe($using, FromInt::applyWith(1))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = -3;
        $expected = new stdClass;
        $expected->i0 = -3;
        $expected->i1 = -2;
        $expected->i2 = -1;
        $expected->i3 = 0;
        $actual = Shoop::pipe($using, FromInt::applyWith(0))->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_json()
    {
        $using = '{}';
        $expected = new stdClass;
        $actual = Shoop::pipe($using, AsObject::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 0.85);

        $using = '{"member":false}';
        $expected->member = false;
        $actual = Shoop::pipe($using, FromJson::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_object()
    {
        $using = new stdClass;
        $using->hello = "hello again";

        $expected = $using;
        $actual = Shoop::pipe($using, AsObject::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_from_string()
    {
        $using = "";

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->string = "";
        $actual = Shoop::pipe($using, AsObject::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $actual = Shoop::pipe($using, FromString::apply())->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}
