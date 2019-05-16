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

    public function testCanDoPlusAndMinusForArray()
    {
        $expected = [1, 2, 3, 4, 5, 6];
        $result = ESArray::wrap([1, 2, 3])->plus([4, 5, 6])->unwrap();
        $this->assertEquals($expected, $result);

        $expected = [1, 2, 4, 2, 1];
        $result = ESArray::wrap([1, 2, 3, 4, 3, 2, 1])->minus([3])->unwrap();
        $this->assertEquals($expected, $result);
    }

    public function testCanCountContents()
    {
        $result = ESArray::wrap([1, 2, 3])->count()->unwrap();
        $this->assertEquals(3, $result);
    }
}
