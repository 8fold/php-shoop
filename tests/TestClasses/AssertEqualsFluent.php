<?php

namespace Eightfold\Shoop\Tests\TestClasses;

use PHPUnit\Framework\TestCase;

use Eightfold\Foldable\Filterable;
use Eightfold\Foldable\FilterableImp;

use Eightfold\Shoop\Shooped;

class AssertEqualsFluent extends TestCase implements Filterable
{
    use FilterableImp;

    private $expected;
    private $expectedClassName;

    protected $start;
    private $maxMs = 0.3;

    public function __construct(
        $expected,
        $expectedClassName,
        float $maxMs = 0.3
    )
    {
        $this->start = hrtime(true);
        $this->maxMs = $maxMs;

        $this->expected          = $expected;
        $this->expectedClassName = $expectedClassName;
    }

    public function unfoldUsing($using)
    {
        $actual = (is_a($using, Shooped::class)) ? $using->unfold() : $using;

        $end = hrtime(true);

        $this->assertEquals($this->expected, $actual);

        $actual = (is_a($using, Shooped::class))
            ? get_class($using)
            : gettype($using);
        $this->assertEquals($this->expectedClassName, $actual);

        $elapsed = $end - $this->start;
        $ms = $elapsed/1e+6;

        $msPasses = $ms <= $this->maxMs;
        $this->assertTrue($msPasses, "{$ms}ms is greater than {$this->maxMs}ms");
    }
}
