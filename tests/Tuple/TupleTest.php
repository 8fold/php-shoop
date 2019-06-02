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

    public function testCanUnwrapTuple()
    {
        $result = ESTuple::wrap("left", 1, "right", 2)->unwrap();
        $this->assertEquals(["left" => 1, "right" => 2], $result);
    }
}
