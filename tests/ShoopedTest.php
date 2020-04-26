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
        $this->assertEquals(['i0' => 3], $base->dictionary()->unfold());
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
        $result = TestObject::fold($base)->has(2);
        $this->assertTrue($result->unfold());

        $result = TestObject::fold($base)->doesNotStartWith([1, 2]);
        $this->assertFalse($result->unfold());

        $result = TestObject::fold($base)->doesNotEndWith([1, 2]);
        $this->assertTrue($result->unfold());
    }

    public function testCanMath()
    {
        $expected = 16;
        $actual = TestObject::fold(8)->multiply(2);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testCanCompare()
    {
        $base = "hello";
        $result = TestObject::fold($base);
        $this->assertTrue($result->isUnfolded($base));
        $this->assertFalse($result->isNotUnfolded($base));

        // $this->assertFalse($result->isEmptyUnfolded());

        $this->assertTrue(TestObject::fold(10)->isGreaterThanUnfolded(9));
        $this->assertTrue(TestObject::fold(10)->isGreaterThanOrEqualUnfolded(10));
        $this->assertTrue(TestObject::fold(10)->isLessThanUnfolded(11));
        $this->assertTrue(TestObject::fold(10)->isLessThanOrEqualUnfolded(10));
    }

    public function testPhpTransportabilityString()
    {
        $expected = "Array([0] => 1, [1] => 2)";
        $actual = TestObject::fold([1, 2]);
        $this->assertEquals($expected, $actual);

        $expected = "Hello!";
        $actual = TestObject::fold($expected);
        $this->assertEquals($expected, $actual);

        $expected = " [";
        $actual = TestObject::fold($expected);
        $this->assertEquals($expected, $actual);

        $expected = "12";
        $actual = TestObject::fold(12);
        $this->assertEquals($expected, $actual);

        // Will be Dictionary when class is ESDictionary
        $expected = "Array([one] => 1, [two] => 2)";
        $actual = TestObject::fold(["one" => 1, "two" => 2]);
        $this->assertEquals($expected, $actual);
    }

    public function testPhpTransportabilityArrayAccess()
    {
        $expected = [1, 2, 3];
        $array = TestObject::fold($expected);

        $this->assertTrue($array->offsetExists(0));
        $this->assertEquals(2, $array->offsetGet(1));

        $array[0] = 3;
        $this->assertEquals([3, 2, 3], $array->unfold());

        unset($array[2]);
        $this->assertEquals([3, 2], $array->unfold());
    }
}
