<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;

use \stdClass;

use Eightfold\Shoop\PipeFilters\DropRange;

/**
 * @group Drop
 */
class DropTest extends TestCase
{
    /**
     * @test
     */
    public function string()
    {
        $using = "Do you remember when, we using to sing?";

        $this->start = hrtime(true);
        $expected = true;

        $actual = StringStartsWith::applyWith("Do you")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 2.8);

        $this->start = hrtime(true);
        $expected = false;

        $actual = StringStartsWith::applyWith("Do you...")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 2.9);
    }
}
