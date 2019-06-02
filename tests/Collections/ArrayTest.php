<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    Shoop,
    ESArray
};

class ArrayTest extends TestCase
{
    public function testCanInitialize()
    {
        $result = ESArray::wrap(1, 2, 3);
        $this->assertEquals([1, 2, 3], $result->unwrap());

        $compare = ESArray::wrap(1, 2, 3);
        $this->assertTrue($result->isSameAs($compare)->unwrap());

        $compare = ESArray::wrap(3, 2, 1);
        $this->assertTrue($result->isDifferentThan($compare)->unwrap());

        $this->assertEquals("[1, 2, 3]", $result->description()->unwrap());

        $result = ESArray::wrap();
        $this->assertTrue($result->isEmpty()->unwrap());
    }

    public function testCanDoPlusAndMinusForArray()
    {
        $expected = [1, 2, 3, 4, 5, 6];
        $result = ESArray::wrap(1, 2, 3)->plus(4, 5, 6)->unwrap();
        $this->assertEquals($expected, $result);

        $expected = [1, 2, 4, 2, 1];
        $result = ESArray::wrap(1, 2, 3, 4, 3, 2, 1)->minus(3)->unwrap();
        $this->assertEquals($expected, $result);
    }

    public function testCanCountContents()
    {
        $result = ESArray::wrap(1, 2, 3)->count()->unwrap();
        $this->assertEquals(3, $result);
    }

    public function testCanSortAnArray()
    {
        $expected = [1, 2, 3, 4, 5];
        $result = ESArray::wrap(4, 2, 3, 1, 5)->sorted()->unwrap();
        $this->assertEquals($expected, $result);

        $shuffled = ESArray::wrap(...$expected)->shuffled()->unwrap();
        $this->assertNotEquals($expected, $shuffled);
    }

    public function testCanReverseArrayAndPutItBack()
    {
        $expected = [5, 4, 3, 2, 1];
        $original = [1, 2, 3, 4, 5];
        $result = ESArray::wrap(...$original);
        $reversed = $result->toggle();
        $this->assertEquals($expected, $reversed->unwrap());

        $orig = $reversed->toggle();
        $this->assertEquals($original, $orig->unwrap());
    }

    public function testCanGetFirstAndLastViaMinAndMax()
    {
        $result = ESArray::wrap(1, 2, 3, 4, 5);
        $this->assertEquals(1, $result->first()->unwrap());
        $this->assertEquals(5, $result->last()->unwrap());

        $result = ESArray::wrap();
        $this->assertEquals([], $result->first()->unwrap());
        $this->assertEquals([], $result->last()->unwrap());
    }

    public function testDropFirstAndLast()
    {
        $expected = [3, 4, 5];
        $result = ESArray::wrap(1, 2, 3, 4, 5)->dropFirst(2)->unwrap();
        $this->assertEquals($expected, $result);

        $expected = [1, 2, 3];
        $result = ESArray::wrap(1, 2, 3, 4, 5)->dropLast(2)->unwrap();
        $this->assertEquals($expected, $result);
    }

    public function testCanMultiplyAndDivide()
    {
        $expected = [1, 2, 3, 1, 2, 3, 1, 2, 3];
        $result = ESArray::wrap(1, 2, 3)->multipliedBy(3)->unwrap();
        $this->assertEquals($expected, $result);

        $result = ESArray::wrap(1, 2, 3, 4, 5, 6)->dividedBy(3);
        $lhs = $result->lhs();
        $rhs = $result->rhs();
        $this->assertEquals([1, 2, 3], $lhs->unwrap());
        $this->assertEquals([4, 5, 6], $rhs->unwrap());
    }

    public function testCanInsertValueAtIndex()
    {
        $expected = [1, 2, 3, "Hello", "World", 4, 5];
        $result = ESArray::wrap(1, 2, 3, 4, 5);
        $testResult = $result->insertAtIndex(["Hello", "World"], 3)
            ->unwrap();
        $this->assertEquals($expected, $testResult);

        $this->assertEquals([1, 2, 4, 5], $result->removeAtIndex(2)->unwrap());
    }

    public function testCanJoinStringArray()
    {
        $result = ESArray::wrap("a", "b", "c")->joined()->unwrap();
        $this->assertEquals("abc", $result);
    }

    public function testCanBeIteratedOver()
    {
        $array = Shoop::array(1, 2, 3, 4, 5);
        $this->assertEquals([1, 2, 3, 4, 5], $array->unwrap());
        $count = 1;
        foreach ($array as $int) {
            $this->assertEquals($count, $int->unwrap());
            $count++;
        }
        $this->assertTrue($count > 1);
    }
}
