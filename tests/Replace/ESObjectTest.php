<?php

namespace Eightfold\Shoop\Tests\Replace;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Php;

use Eightfold\Shoop\ESObject;

class ESObjectTest extends TestCase
{
    public function test_type_juggling()
    {
        $object = new stdClass;
        $object->member = true;

        $expected = [true];
        $actual = Php::objectToArray($object);
        $this->assertEqualsWithPerformance($expected, $actual);
        $this->assertTrue($object->member);

        $this->start = hrtime(true);
        $expected = true;
        $actual = Php::objectToBool($object);
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = ["member" => true];
        $actual = Php::objectToDictionary($object);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = 1;
        $actual = Php::objectToInt($object);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = '{"member":true}';
        $actual = Php::objectToJson($object);
        $this->assertEqualsWithPerformance($expected, $actual);

        $object = new stdClass;
        $object->member = "H";
        $object->member2 = true;
        $object->member3 = "i";

        $expected = "Hi";
        $actual = Php::objectToString($object);
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}
