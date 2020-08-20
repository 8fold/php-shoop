<?php

namespace Eightfold\Shoop\Tests;

use Eightfold\Foldable\Filterable;
use Eightfold\Foldable\FilterableImp;

// use Eightfold\Shoop\Tests\TestCase;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class AssertEquals extends TestCase implements Filterable
{
    use FilterableImp;

    private $expected;
    private $filter;

    protected $start;
    private $maxMs = 0.3;

    public function __construct(
        $expected,
        Filterable $filter,
        float $maxMs = 0.3
    )
    {
        $this->start = hrtime(true);
        $this->maxMs = $maxMs;

        $this->expected = $expected;
        $this->filter   = $filter;
    }

    public function unfoldUsing($using)
    {
        $actual = $this->filter->unfoldUsing($using);
        $end = hrtime(true);

        $this->assertEquals($this->expected, $actual);

        $elapsed = $end - $this->start;
        $ms = $elapsed/1e+6;

        $msPasses = $ms <= $this->maxMs;
        $this->assertTrue($msPasses, "{$ms}ms is greater than {$this->maxMs}ms");
    }
}
