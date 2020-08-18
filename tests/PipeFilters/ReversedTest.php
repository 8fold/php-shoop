<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;

use \stdClass;

use Eightfold\Shoop\PipeFilters\Reversed;

/**
 * @group Reversed
 */
class ReversedTest extends TestCase
{
    /**
     * @test
     */
    public function list()
    {
        $using = [1, 2, 3];

        $expected = [3, 2, 1];

        $actual = Reversed::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 4.55);

        $this->start = hrtime(true);
        $using = ["a" => 1, "b" => 2, "c" => 3];

        $expected = ["c" => 3, "b" => 2, "a" => 1];

        $actual = Reversed::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function boolean()
    {
        $using = true;

        $this->start = hrtime(true);
        $expected = false;

        $actual = Reversed::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 0.7);
    }

    /**
     * @test
     */
    public function number()
    {
        $using = 1;

        $this->start = hrtime(true);
        $expected = -1;

        $actual = Reversed::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 0.7);

        $using = -2.5;

        $this->start = hrtime(true);
        $expected = 2.5;

        $actual = Reversed::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function string()
    {
        $using = "!dlof8";

        $this->start = hrtime(true);
        $expected = "8fold!";

        $actual = Reversed::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 4.3);
    }

    /**
     * @test
     */
    public function tuple()
    {
        $using = new stdClass;
        $using->first = true;
        $using->last  = false;

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->last  = false;
        $expected->first = true;

        $actual = Reversed::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 1.7);
    }

    /**
     * @test
     */
    public function object()
    {
        $using = new class {
            public $public = "content";
            public $public2 = "content2";
            private $private;

            public function __construct()
            {
                $this->private = "content";
            }
        };

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->public2  = "content2";
        $expected->public  = "content";

        $actual = Reversed::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 0.85);
    }

    /**
     * @test
     */
    public function json()
    {
        $using = '{}';

        $this->start = hrtime(true);
        $expected = '{}';

        $actual = Reversed::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 1.35);

        $using = '{"member":1,"member2":2}';

        $this->start = hrtime(true);
        $expected = '{"member2":2,"member":1}';

        $actual = Reversed::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}
