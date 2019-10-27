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

        $actual = ESDictionary::fold($dict)->json();
        $this->assertEquals('{"one":1,"two":2}', $actual->unfold());
    }

    public function testCanManipulate()
    {
        $dict = ["zero" => 0, "one" => 1];
        $expected = [];
        $actual = ESDictionary::fold($dict)->toggle();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testSearch()
    {
        $base = ["one" => 1, "two" => 2];
        $shoopDict = Shoop::dictionary($base);
        $result = $shoopDict->has(1);
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

    public function testPhpTransportabilityToString()
    {
        // __toString
        $expected = "Dictionary([hello] => world)";
        $actual = ESDictionary::fold(["hello" => "world"]);
        $this->assertEquals($expected, "{$actual}");
    }

    public function testTransportabilitySetAndPlus()
    {
        $dict = ["hello" => "world"];
        $actual = ESDictionary::fold([])->plus("hello", "world");
        $this->assertEquals($dict["hello"], $actual->hello);

        $obj = (object) ["hello" => ["world", "chat"]];
        $actual = ESDictionary::fold(["hello" => "world"])->plus("hello", "chat", false);
        $this->assertEquals($obj->hello, $actual->hello);

        $obj = (object) ["hello" => "chat"];
        $actual = ESDictionary::fold([])->set("hello", "chat");
        $this->assertEquals($obj->hello, $actual->hello);
    }

    public function testPhpTransportabilityCall()
    {
        $expected = Shoop::string("world");
        $actual = ESDictionary::fold(["hello" => "world"])->getHello();
        $this->assertEquals($expected, $actual);

        $obj = (object) ["hello" => ["world", "chat"]];
        $actual = ESDictionary::fold(["hello" => "world"])->setHello("chat", false);
        $this->assertEquals($obj->hello, $actual->hello);

        $this->assertEquals($obj->hello, $actual->helloUnfolded());
    }

    public function testTransportabilitySetGetIssetAndUnset()
    {
        $obj = new \stdClass();
        $obj->hello = ["world", "chat"];

        $object = Shoop::object([]);
        $object->hello = ["world", "chat"];

        $this->assertEquals($obj, $object->unfold());
        $this->assertEquals($obj->hello, $object->hello);

        $this->assertTrue(isset($object->hello));
        $this->assertFalse(isset($object->goodbye));

        unset($object->hello);
        $this->assertFalse(isset($object->hello));

        $expected = ["world", "chat"];
        $object = Shoop::object([])
            ->plus("hello", "world")
            ->set("hello", "chat", false);
        $this->assertEquals($expected, $object->get("hello"));

        // TODO: Need more tests to verify getting in all the ways
    }

    public function testPhpTransportabilityArrayAccess()
    {
        $object = Shoop::object([])
            ->plus("hello", "world")
            ->set("hello", "chat", false);
        $this->assertFalse(empty($object));

        $objectNull = Shoop::object([]);
        $this->assertTrue(empty($objectNull[0]));

        $this->assertEquals(["world", "chat"], $object["hello"]);

        $object = Shoop::object([]);
        $object->hello = ["world", "chat"];
        $this->assertEquals(["world", "chat"], $object->hello);

        unset($object["hello"]);
        $this->assertNull($object["hello"]);
    }

    public function testPhpTransportabilityIterator()
    {
        $object = Shoop::object(["one" => 1, "two" => 2]);
        $count = 0;
        foreach ($object as $key => $value) {
            if ($key === "one") {
                $this->assertEquals(1, $value);
                $count++;

            } elseif ($key === "two") {
                $this->assertEquals(2, $value);
                $count++;

            }
        }
        $this->assertEquals(2, $count);
    }
}
