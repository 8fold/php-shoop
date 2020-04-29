<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    Shoop,
    ESArray,
    Helpers\Type
};

class ArrayTest extends TestCase
{
    public function testTypeJuggling()
    {
        $base = [1, 2];
        $array = Shoop::array($base);

        $array->offsetUnset(0);

        $this->assertEquals(2, $array[1]);
        $this->assertEquals(2, $array->getUnfolded(1));

        $array = $array->array();
        $this->assertEquals(2, $array[0]);
        $this->assertEquals(2, $array->getUnfolded(0));

        $dict = $array->dictionary();
        $this->assertTrue(Type::isDictionary($dict));
        $this->assertEquals(["i0" => 2], $dict->unfold());

        // $actual = $array->json();
        // $this->assertEquals('{"0":1,"1":2}', $actual->unfold());
    }

    public function testPhpInterfaces()
    {
        $expected = "Array([0] => 1)";
        $actual = (string) Shoop::array([1]);
        $this->assertEquals($expected, $actual);
    }

    public function testManipulations()
    {
        $expected = [3, 2, 1];
        $expected2 = [1, 2, 3];
        $actual = Shoop::array($expected2)->toggle();
        $this->assertEquals($expected, $actual->unfold());

        $actual = Shoop::array($expected)->sort();
        $this->assertEquals($expected2, $actual->unfold());

        $actual = Shoop::array([2, 1])->start(3);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testSearch()
    {
        $array = [1, 2, 3];
        $shoopArray = Shoop::array($array);

        $result = $shoopArray->startsWith([1, 2]);
        $this->assertTrue($result->unfold());

        $result = $shoopArray->endsWith([2, 3]);
        $this->assertTrue($result->unfold());
    }

    public function testMathLanguage()
    {
        // $expected = [1, 2, 3, 4, 5, 6];
        // $result = ESArray::fold([1, 2, 3])->plus([4, 5, 6])->unfold();
        // $this->assertEquals($expected, $result);

        $expected = [1, 2, 3, 4];
        $result = ESArray::fold([1, 2])->plus(3, 4)->unfold();
        $this->assertEquals($expected, $result);

        // $expected = [1, 2, 4, 2, 1];
        // $result = ESArray::fold([1, 2, 3, 4, 3, 2, 1])->minus(3);
        // $this->assertEquals($expected, $result->unfold());

        // $expected = [1, 1, 1, 1, 1];
        // $actual = ESArray::fold([1])->multiply(4);
        // $this->assertEquals($expected, $actual->unfold());

        $expected = [
            [1, 2, 4],
            [2, 1]
        ];
        $actual = ESArray::fold([1, 2, 4, 2, 1])->divide(3);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testGetters()
    {
        $result = ESArray::fold([1, 2, 3, 4, 5]);
        $this->assertEquals(1, $result->first()->unfold());
        $this->assertEquals(5, $result->last()->unfold());
        $this->assertEquals(1, $result->firstUnfolded());
        $this->assertEquals(5, $result->lastUnfolded());

        $result = ESArray::fold([]);
        $this->assertEquals([], $result->first()->unfold());
        $this->assertEquals([], $result->last()->unfold());
    }

    public function testOther()
    {
        $result = ESArray::fold(["a", "b", "c"])->join()->unfold();
        $this->assertEquals("abc", $result);

        $expected = [3, 4, 5];
        $result = ESArray::fold([1, 2, 3, 4, 5])->dropFirst(2)->unfold();
        $this->assertEquals($expected, $result);

        $expected = [1, 2, 3];
        $result = ESArray::fold([1, 2, 3, 4, 5])->dropLast(2)->unfold();
        $this->assertEquals($expected, $result);

        $expected = [1, 2, 3, "Hello", "World", 4, 5];
        $result = ESArray::fold([1, 2, 3, 4, 5]);
        $testResult = $result->insertAt(["Hello", "World"], 3)
            ->unfold();
        $this->assertEquals($expected, $testResult);

        $this->assertEquals([1, 2, 4, 5], $result->drop(2)->unfold());

        $expected = [2, 3, 4];
        $actual = Shoop::array([1, 2, 3])->each(function ($value) {
            return $value + 1;
        });
        $this->assertEquals($expected, $actual->unfold());

        $array = Shoop::array([1, 2, 3, 4, 5]);
        $this->assertEquals([1, 2, 3, 4, 5], $array->unfold());
        $count = 1;
        foreach ($array as $int) {
            $this->assertEquals($count, $int);
            $count++;
        }
        $this->assertTrue($count > 1);

        $expected = 6;
        $actual = Shoop::array([1, 2, 3])->summed();
        $this->assertEquals($expected, $actual->unfold());
    }
}
