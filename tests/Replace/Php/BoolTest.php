<?php

namespace Eightfold\Shoop\Tests\Replace\Php;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Php;

class BoolTest extends TestCase
{
    public function test_type_juggling()
    {
        $expected = [false];
        $actual = Php::booleanToArray(false);
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->true  = true;
        $expected->false = false;
        $expected = ["true" => true, "false" => false];
        $actual = Php::booleanToDictionary(true);
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->true  = false;
        $expected->false = true;
        $expected = ["true" => false, "false" => true];
        $actual = Php::booleanToDictionary(false);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = 1;
        $actual = Php::booleanToInteger(true);
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = 0;
        $actual = Php::booleanToInteger(false);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = '{"true":true,"false":false}';
        $actual = Php::booleanToJson(true);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = '{"true":false,"false":true}';
        $actual = Php::booleanToJson(false);
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->true  = true;
        $expected->false = false;
        $actual = Php::booleanToObject(true);
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->true  = false;
        $expected->false = true;
        $actual = Php::booleanToObject(false);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = "true";
        $actual = Php::booleanToString(true);
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}
