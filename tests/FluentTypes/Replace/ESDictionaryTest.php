<?php

namespace Eightfold\Shoop\Tests\Replace;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\FluentTypes\ESDictionary;

class ESDictionaryTest extends TestCase
{
    public function test_type_juggling()
    {
        $expected = [1, 2];
        $actual = ESDictionary::fold(["first" => 1, "second" => 2])
            ->array()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.4);

        $this->start = hrtime(true);
        $expected = true;
        $actual = ESDictionary::fold(["first" => 1, "second" => 2])
            ->bool()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.7);

        $this->start = hrtime(true);
        $expected = 2;
        $actual = ESDictionary::fold(["first" => 1, "second" => 2])
            ->int()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.5);

        $expected = '{"first":1,"second":2}';
        $actual = ESDictionary::fold(["first" => 1, "second" => 2])
            ->json()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->first = 1;
        $expected->second = 2;
        $actual = ESDictionary::fold(["first" => 1, "second" => 2])
            ->object()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 2.4);

        $this->start = hrtime(true);
        $expected = "8fold";
        $actual = ESDictionary::fold(["prefix" => "8f", "suffix" => "ld"])
            ->string("o")->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.2);
    }
}
