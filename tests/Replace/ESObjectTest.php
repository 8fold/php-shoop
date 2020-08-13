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

        $object = new stdClass;
        $object->member = "H";
        $object->member2 = true;
        $object->member3 = "i";
    }
}
