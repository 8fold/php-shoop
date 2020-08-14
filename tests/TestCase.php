<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

abstract class TestCase extends PHPUnitTestCase
{
    /**
     * Seems to be upper limit of local machine. More typical is around 0.05.
     *
     * Includes any time between PHPUnit call to `setUp()` and each unit test.
     */
    protected $maxMilliseconds = 0.6;

    protected $start = 0;

    protected function setUp(): void
    {
        $this->start = hrtime(true);
    }

    protected function assertEqualsWithPerformance(
        $expected,
        $actual,
        $maxMilliseconds = 0
    ): void
    {
        $elapsed = hrtime(true) - $this->start;
        $milliseconds = $elapsed/1e+6;

        $this->assertEquals($expected, $actual);

        $maxMilliseconds = ($maxMilliseconds === 0)
            ? $this->maxMilliseconds
            : $maxMilliseconds;

        $this->assertTrue(
            $milliseconds <= $maxMilliseconds,
            "{$milliseconds}ms is greater than {$maxMilliseconds}ms");
    }
}
