<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\ESTuple;

class TupleTest extends TestCase
{
    public function testCanInitialize()
    {
        $result = ESTuple::wrap("key", "value");
        $this->assertNotNull($result);
    }
}
