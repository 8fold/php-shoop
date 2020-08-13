<?php

namespace Eightfold\Shoop\Tests\Replace\Php;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Php;

class BoolTest extends TestCase
{
    public function test_type_juggling()
    {
        $expected = 1;
        $actual = Php::booleanToInteger(true);
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = 0;
        $actual = Php::booleanToInteger(false);
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}
