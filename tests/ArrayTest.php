<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    Shoop,
    ESArray
};

class ArrayTest extends TestCase
{
    public function testCanInitializeArr()
    {
        $result = ESArray::fold([1, 2, 3]);
        $this->assertEquals([1, 2, 3], $result->unfold());

        $compare = ESArray::fold([1, 2, 3]);
        $this->assertTrue($result->isSame($compare)->unfold());

        $compare = ESArray::fold([3, 2, 1]);
        $this->assertTrue($result->isNotUnfolded($compare));
    }

    public function testCanDoPlusAndMinusForArray()
    {
        $expected = [1, 2, 3, 4, 5, 6];
        $result = ESArray::fold([1, 2, 3])->plus([4, 5, 6])->unfold();
        $this->assertEquals($expected, $result);

        $expected = [1, 2, 3, 4];
        $result = ESArray::fold([1, 2])->plus(3, 4)->unfold();
        $this->assertEquals($expected, $result);

        $expected = [1, 2, 4, 2, 1];
        $result = ESArray::fold([1, 2, 3, 4, 3, 2, 1])->minus(3)->unfold();
        $this->assertEquals($expected, $result);
    }

    public function testCanCountContents()
    {
        $array = ESArray::fold([1, 2, 3]);
        $result = $array->count()->unfold();
        $this->assertEquals(3, $result);

        $this->assertTrue($array->isLessThanUnfolded(4));
        $this->assertTrue($array->isGreaterThanOrEqualUnfolded(3));
        $this->assertTrue($array->isGreaterThanUnfolded(0));
        $this->assertTrue($array->isLessThanOrEqualUnfolded(4));
    }

    public function testCanSortAnArray()
    {
        $expected = [1, 2, 3, 4, 5];
        $result = ESArray::fold([4, 2, 3, 1, 5])->sort()->unfold();
        $this->assertEquals($expected, $result);
    }

    public function testCanReverseArrayAndPutItBack()
    {
        $expected = [5, 4, 3, 2, 1];
        $original = [1, 2, 3, 4, 5];
        $result = ESArray::fold($original);
        $reversed = $result->toggle();
        $this->assertEquals($expected, $reversed->unfold());

        $orig = $reversed->toggle();
        $this->assertEquals($original, $orig->unfold());
    }

    public function testCanGetFirstAndLastViaMinAndMax()
    {
        $result = ESArray::fold([1, 2, 3, 4, 5]);
        $this->assertEquals(1, $result->firstUnfolded());
        $this->assertEquals(5, $result->lastUnfolded());

        $result = ESArray::fold([]);
        $this->assertEquals([], $result->first()->unfold());
        $this->assertEquals([], $result->last()->unfold());
    }

    public function testDropFirstAndLast()
    {
        $expected = [3, 4, 5];
        $result = ESArray::fold([1, 2, 3, 4, 5])->dropFirst(2)->unfold();
        $this->assertEquals($expected, $result);

        $expected = [1, 2, 3];
        $result = ESArray::fold([1, 2, 3, 4, 5])->dropLast(2)->unfold();
        $this->assertEquals($expected, $result);
    }

    // public function testCanMultiplyAndDivide()
    // {
    //     $expected = [1, 2, 3, 1, 2, 3, 1, 2, 3];
    //     $result = ESArray::fold([1, 2, 3])->multipliedBy(3)->unfold();
    //     $this->assertEquals($expected, $result);

    //     $result = ESArray::fold([1, 2, 3, 4, 5, 6])->dividedBy(3);
    //     $lhs = $result->lhs();
    //     $rhs = $result->rhs();
    //     $this->assertEquals([1, 2, 3], $lhs->unfold());
    //     $this->assertEquals([4, 5, 6], $rhs->unfold());
    // }

    public function testCanInsertValueAtIndex()
    {
        $expected = [1, 2, 3, "Hello", "World", 4, 5];
        $result = ESArray::fold([1, 2, 3, 4, 5]);
        $testResult = $result->insertAtIndex(["Hello", "World"], 3)
            ->unfold();
        $this->assertEquals($expected, $testResult);

        $this->assertEquals([1, 2, 4, 5], $result->removeAtIndex(2)->unfold());
    }

    public function testCanJoinStringArray()
    {
        $result = ESArray::fold(["a", "b", "c"])->join()->unfold();
        $this->assertEquals("abc", $result);
    }

    public function testCanBeIteratedOver()
    {
        $array = Shoop::array([1, 2, 3, 4, 5]);
        $this->assertEquals([1, 2, 3, 4, 5], $array->unfold());
        $count = 1;
        foreach ($array as $int) {
            $this->assertEquals($count, $int->unfold());
            $count++;
        }
        $this->assertTrue($count > 1);
    }

    public function testCanCheckForContains()
    {
        $array = [1, 2, 3];
        $shoopArray = Shoop::array($array);
        $result = $shoopArray->contains(2);
        $this->assertTrue($result->unfold());

        $result = $shoopArray->startsWith([1, 2]);
        $this->assertTrue($result->unfold());

        $result = $shoopArray->endsWith([2, 3]);
        $this->assertTrue($result->unfold());
    }
}
