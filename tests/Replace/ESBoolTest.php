<?php

namespace Eightfold\Shoop\Tests\Replace;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\ESBool;

class ESBoolTest extends TestCase
{
    public function test_type_juggling()
    {
        $expected = "true";
        $actual = ESBool::fold(true)->string()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1.25);
    }
}
