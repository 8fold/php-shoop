<?php

namespace Eightfold\Shoop\Tests\Replace\Php;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Php;

class BoolTest extends TestCase
{
    public function test_type_juggling()
    {
        $expected = "true";
        $actual = Php::booleanToString(true);
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}
