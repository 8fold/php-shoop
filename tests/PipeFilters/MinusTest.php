<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;

use \stdClass;

use Eightfold\Shoop\PipeFilters\Minus;

/**
 * @group Minus
 */
class MinusTest extends TestCase
{
    /**
     * @test
     */
    public function from_number()
    {
        $using = 1;

        $this->start = hrtime(true);
        $expected = 0;

        $actual = Minus::applyWith(1)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 4.65);

        $using = -1.2;

        $this->start = hrtime(true);
        $expected = -2.7;

        $actual = Minus::applyWith(1.5)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = -5.5;

        $expected = 1;

        $actual = Minus::applyWith(-6.5)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function from_lists()
    {
        $using = [1, "string", true];

        $this->start = hrtime(true);
        $expected = [1, true];

        $actual = Minus::applyWith("string")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 3.45);

        $this->start = hrtime(true);
        $expected = ["string"];

        $actual = Minus::applyWith(true, 1)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = ["one" => 1, "stringKey" => "string", "true" => true];

        $expected = [1, true];

        $actual = Minus::applyWith("string")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = ["string"];

        $actual = Minus::applyWith(1, true)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function from_string()
    {
        $using = "  Do you remember when, we used to sing?  ";

        $this->start = hrtime(true);
        $expected = "Do you remember when, we used to sing?";

        $actual = Minus::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 3.8);

        $this->start = hrtime(true);
        $expected = "Do you remember when, we used to sing?  ";

        $actual = Minus::applyWith(true, false)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 1.5);

        $expected = "  Do you remember when, we used to sing?";

        $actual = Minus::applyWith(false, true)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = "Doyourememberwhen,weusedtosing?";

        $actual = Minus::applyWith(false, false)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = "Dyrmmbrwhn,wsdtsng?";

        $actual = Minus::applyWith(false, false, [" ", "a", "e", "i", "o", "u"])
            ->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = "  Do you remember when, we used to sing?";

        $actual = Minus::applyWith(false, true, [" ", "a", "e", "i", "o", "u"])
            ->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = "Do you remember when, we used to sing?";

        $actual = Minus::applyWith(true, true, [" ", "a", "e", "i", "o", "u"])
            ->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = "Do you remember when, we used to sing?  ";

        $actual = Minus::applyWith(true, false, [" ", "a", "e", "i", "o", "u"])
            ->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function from_boolean()
    {
        $using = true;

        $this->start = hrtime(true);
        $expected = true;

        $actual = Minus::applyWith(0)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 1.4);

        $this->start = hrtime(true);
        $expected = false;

        $actual = Minus::applyWith(1)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = true;

        $actual = Minus::applyWith(2)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function from_tuples()
    {
        $using = (object) ["one" => 1, "stringKey" => "string", "true" => true];

        $this->start = hrtime(true);
        $expected = (object) [1, true];

        $actual = Minus::applyWith("string")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 0.75);

        $expected = (object) ["string"];

        $actual = Minus::applyWith(1, true)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}
