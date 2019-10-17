<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Helpers\Type;
use Eightfold\Shoop\ESDictionary;
use Eightfold\Shoop\ESArray;

use Eightfold\Shoop\Tests\TestObject;

class DictTest extends TestCase
{
    public function testCanInitializeDict()
    {
        $result = Shoop::dictionary(["key" => "value"]);
        $this->assertNotNull($result);

        $this->assertEquals("value", $result["key"]);
    }

    public function testCanTypeJuggle()
    {
        $expected = [1, 2];
        $dict = ["one" => 1, "two" => 2];
        $result = ESDictionary::fold($dict)->array();
        $this->assertEquals($expected, $result->unfold());

        $result = ESDictionary::fold($dict)->dictionary();
        $this->assertEquals($dict, $result->unfold());
    }

    public function testPHPSingleMethodInterfaces()
    {
        $expected = "Array([zero] => 0, [one] => 1)";
        $result = (string) ESDictionary::fold(["zero" => 0, "one" => 1]);
        $this->assertEquals($expected, $result);
    }

    public function testCanManipulate()
    {
        $dict = ["zero" => 0, "one" => 1];
        $expected = [];
        $actual = ESDictionary::fold($dict)->toggle();
        $this->assertEquals($expected, $actual->unfold());

        // $actual = $actual->sort();
        // $this->assertEquals(["zero" => 0, "one" => 1], $actual->unfold());
    }

    public function testSearch()
    {
        $base = ["one" => 1, "two" => 2];
        $shoopDict = Shoop::dictionary($base);
        $result = $shoopDict->has(1);
        $this->assertTrue($result->unfold());

        $result = $shoopDict->startsWith([1, 2]);
        $this->assertTrue($result->unfold());
    }

    public function testDictionaryCanMath()
    {
        $expected = ["zero" => 0, "one" => 1];
        $result = ESDictionary::fold(["zero" => 0])->plusUnfolded("one", 1);
        $this->assertEquals($expected, $result);

        $result = ESDictionary::fold($expected)->minusUnfolded("zero");
        $this->assertEquals(["one" => 1], $result);

        $base = ["one" => 1, "two" => 2];
        $expected = [
            $base,
            $base,
            $base
        ];
        $result = ESDictionary::fold($base)->multiplyUnfolded(3);
        $this->assertEquals($expected, $result);

        $result = Shoop::dictionary($base)->divide();
        $expected = [
            "keys" => ["one", "two"],
            "values" => [1, 2]
        ];
        $this->assertEquals($expected, $result->unfold());
    }

    public function testCanGetValueForKey()
    {
        $assoc = [
            "one" => 1,
            "two" => [1, 2],
            "three" => (object) [
                "one" => 1,
                "two" => 2
            ],
            "four" => Shoop::array([1, 2]),
            "five" => (new TestObject)
        ];

        $dict = Shoop::dictionary($assoc);
        $this->assertEquals(1, $dict->getUnfolded("one"));

        $this->assertTrue(
            is_array(
                $dict->getUnfolded("two")
            )
        );

        $this->assertTrue(
            is_a(
                $dict->getUnfolded("three"),
                \stdClass::class
            )
        );

        $this->assertTrue(Type::isShooped($dict->get("four")));

        $this->assertTrue(
            is_a(
                $dict->getUnfolded("five"),
                TestObject::class
            )
        );
    }









    public function testCanIterateDictionary()
    {
        $dict = Shoop::dictionary(["key" => "value", "key2" => "value2"]);
        $this->assertEquals(["key" => "value", "key2" => "value2"], $dict->unfold());
        $count = 1;
        foreach($dict as $key => $value) {
            if ($key === "key") {
                $this->assertEquals("value", $value);

            } elseif ($key === "key2") {
                $this->assertEquals("value2", $value);

            }
            $count++;
        }
        $this->assertTrue($count > 1);
    }







}
