<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Tests\TestObject;

class ShoopedTest extends TestCase
{
    public function testCanInitialize()
    {
        $result = TestObject::fold(12);
        $this->assertNotNull($result);
        $this->assertEquals(12, $result->unfold());
    }

    public function testFoldAndUnfold()
    {
        $result = TestObject::fold(12);
        $this->assertNotNull($result);
        $this->assertEquals(12, $result->unfold());

        // fold -> from PHP to Shoop
        // unfold -> from Shoop to PHP
        $object = (object) ["one" => 1, "two" => 2];
        $expected = [
            [4, 5],
            ["one" => 1, "two" => 2],
            $object
        ];
        $result = Shoop::array([
            Shoop::array([
                Shoop::int(4),
                5
            ]),
            Shoop::dictionary(["one" => 1, "two" => 2]),
            Shoop::object($object)
        ])->unfold();
        $this->assertEquals($expected, $result);
    }

    public function testCanTypeJuggle()
    {
        $base = TestObject::fold(3);

        $this->assertEquals("3", $base->string());
        $this->assertEquals([3], $base->array()->unfold());
        $this->assertEquals([], $base->dictionary()->unfold());
        $this->assertEquals(3, $base->object()->unfold()->scalar);
        $this->assertEquals(3, $base->intUnfolded());
        $this->assertTrue($base->boolUnfolded());
    }

    public function testPhpInterfaces()
    {
        $result = TestObject::fold([1, 2, 3, 4])->countUnfolded();
        $this->assertEquals(4, $result);

        $result = TestObject::fold("Hello");
        $this->assertEquals("Hello", $result);
    }

    public function testCanRearrangeThings()
    {
        $initial = [1, 2, 3];
        $base = TestObject::fold($initial);
        $result = $base->toggleUnfolded();
        $this->assertEquals([3, 2, 1], $result);

        $result = $base->toggle()->sortUnfolded();
        $this->assertEquals($initial, $result);

        $expected = ["a", "b", "c"];
        $sortArray = ["c", "a", "b"];
        $result = TestObject::fold($sortArray)->sortUnfolded();
        $this->assertEquals($expected, $result);

        $alpha = Shoop::string("alpha");
        $beta = Shoop::string("beta");
        $result = TestObject::fold([$alpha, $beta])->sort();
        $this->assertEquals([$alpha->unfold(), $beta->unfold()], $result->unfold());

        $base = [1, 2, 3];
        $expected = [3, 2, 1, 1, 2, 3];
        $result = TestObject::fold($base)->start(3, 2, 1);
        $this->assertEquals($expected, $result->unfold());

        $expected = [1, 2, 3, 3, 2, 1];
        $result = TestObject::fold($base)->end(3, 2, 1);
        $this->assertEquals($expected, $result->unfold());
    }

    public function testCanSearch()
    {
        $base = [1, 2, 3];
        $result = TestObject::fold($base)->contains(2);
        $this->assertTrue($result->unfold());

        $result = TestObject::fold($base)->doesNotStartWith([1, 2]);
        $this->assertFalse($result->unfold());

        $result = TestObject::fold($base)->doesNotEndWith([1, 2]);
        $this->assertTrue($result->unfold());
    }

    public function testCanMath()
    {
        $expected = [5, 4, 1];
        $result = TestObject::fold(5)->plus(4, 1);
        $this->assertEquals($expected, $result->unfold());

        $expected = [5];
        $result = TestObject::fold([1, 1, 1, 5, 2, 2, 2])->minus(1)->minus(2);
        $this->assertEquals($expected, $result->unfold());

        $expected = 25;
        $result = TestObject::fold(5)->multiply(5);
        $this->assertEquals($expected, $result->unfold());

        $expected = 4;
        $result = TestObject::fold(28)->divide(7);
        $this->assertEquals($expected, $result->unfold());

        $result = TestObject::fold(8)->split(2);
        $this->assertEquals($expected, $result->unfold());
    }

    public function testCanCompare()
    {
        $base = "hello";
        $result = TestObject::fold($base);
        $this->assertTrue($result->isUnfolded($base));
        $this->assertFalse($result->isNotUnfolded($base));

        $this->assertFalse($result->isEmptyUnfolded());

        $this->assertTrue(TestObject::fold(10)->isGreaterThanUnfolded(9));
        $this->assertTrue(TestObject::fold(10)->isGreaterThanOrEqualUnfolded(10));
        $this->assertTrue(TestObject::fold(10)->isLessThanUnfolded(11));
        $this->assertTrue(TestObject::fold(10)->isLessThanOrEqualUnfolded(10));
    }
}
