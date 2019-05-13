<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    ESArray
};

class ArrayTest extends TestCase
{
    public function testCanInitialize()
    {
        $result = ESArray::wrap([1, 2, 3]);
        $this->assertEquals([1, 2, 3], $result->unwrap());

        // Shoop object
        // CustomClass
        $this->assertTrue($result->contains(2)->unwrap());
        $this->assertFalse($result->contains(8)->unwrap());

        $compare = ESArray::wrap([1, 2, 3]);
        $this->assertTrue($result->isSameAs($compare)->bool());

        $compare = ESArray::wrap([3, 2, 1]);
        $this->assertTrue($result->isDifferentThan($compare)->bool());

        $this->assertEquals("[1, 2, 3]", $result->description()->unwrap());

        $result->random();
        $result->shuffled();

        $result = ESArray::wrap([]);
        $this->assertTrue($result->isEmpty()->unwrap());
    }
}
