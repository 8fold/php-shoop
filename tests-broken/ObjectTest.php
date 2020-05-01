<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\ESObject;

class ObjectTest extends TestCase
{
    public function testTypeJuggling()
    {
        $expected = [1, 2];
        $cast = (object) ["one" => 1, "two" => 2];
        $actual = Shoop::this($cast)->array();
        $this->assertEquals($expected, $actual->unfold());

        // $actual = Shoop::this($cast)->bool();
        // $this->assertTrue($actual->unfold());

        // $actual = Shoop::this((new \stdClass()))->bool();
        // $this->assertFalse($actual->unfold());

        $json = Shoop::this((new \stdClass()));
        $actual = $json->json();
        $this->assertEquals(json_encode($json), $actual->unfold());
    }

    public function testPhpInterfaces()
    {
        $base = ["one" => 1];
        $actual = (string) Shoop::this((object) $base);
        $this->assertEquals("stdClass Object([one] => 1)", $actual);
    }

    // public function testMathLanguage()
    // {
    //     // $expected = (object) ["one" => 1, "two" => 2];
    //     // $actual = Shoop::this((object) ["one" => 1])->plus(2, "two");
    //     // $this->assertEquals($expected, $actual->unfold());

    //     // $expected2 = (object) ["two" => 2];
    //     // $actual = Shoop::object($expected)->minus("one");
    //     // $this->assertEquals($expected2, $actual->unfold());

    //     // $expected = [
    //     //     (object) ["one" => 1, "two" => 2],
    //     //     (object) ["one" => 1, "two" => 2]
    //     // ];
    //     // $actual = Shoop::this((object) ["one" => 1, "two" => 2])
    //     //     ->multiply(2);
    //     // $this->assertEquals($expected, $actual->unfold());

    //     // $expected = (object) ["members" => ["one", "two"], "values" => [1, 2]];
    //     // $actual = Shoop::this((object) ["one" => 1, "two" => 2])
    //     //     ->divide();
    //     // $this->assertEquals($expected, $actual->unfold());
    // }

    // public function testOther()
    // {
    //     // $expected = "stdClass Object([hello] => world)";
    //     // $actual = ESObject::fold([])->set("world", "hello");
    //     // $this->assertEquals($expected, $actual);

    //     $expected = "stdClass Object([hello] => chat)";
    //     $actual = $actual->set("chat", "hello");
    //     $this->assertEquals($expected, $actual);

    //     $expected = "stdClass Object([hello] => Array([0] => chat, [1] => world))";
    //     $actual = $actual->set("world", "hello", false);
    //     $this->assertEquals($expected, "{$actual}");

    //     $expected = "stdClass Object([hello] => mother)";
    //     $actual = $actual->set("mother", "hello");
    //     $this->assertEquals($expected, $actual);

    //     $actual = Shoop::object(["hello" => "mother"])->has("mother");
    //     $this->assertTrue($actual->unfold());

    //     $actual = Shoop::object(["hello" => "mother"])->hasMember("hello");
    //     $this->assertTrue($actual->unfold());

    //     $actual = Shoop::object(["hello" => "mother"])->has("hello");
    //     $this->assertFalse($actual->unfold());

    //     $actual = Shoop::object(["hello" => "mother"])->hasMember("mother");
    //     $this->assertFalse($actual->unfold());
    // }

    // public function testPhpTransportabilityToString()
    // {
    //     // __toString
    //     $expected = "stdClass Object([hello] => world)";
    //     $actual = ESObject::fold(["hello" => "world"]);
    //     $this->assertEquals($expected, "{$actual}");
    // }

    // public function testTransportabilitySetAndPlus()
    // {
    //     $obj = (object) ["hello" => "world"];
    //     $actual = ESObject::fold([])->plus("world", "hello");
    //     // $this->assertEquals($obj->hello, $actual->hello);

    //     $obj = (object) ["hello" => ["world", "chat"]];
    //     $actual = ESObject::fold(["hello" => "world"])->plus("chat", "hello", false);
    //     // $this->assertEquals($obj->hello, $actual->hello);

    //     $obj = (object) ["hello" => "chat"];
    //     $actual = ESObject::fold([])->set("chat", "hello");
    //     // $this->assertEquals($obj->hello, $actual->hello);
    // }

    public function testPhpTransportabilityCall()
    {
        $expected = Shoop::string("world");
        $actual = ESObject::fold(["hello" => "world"])->getHello();
        $this->assertEquals($expected, $actual);

        // $obj = (object) ["hello" => ["world", "chat"]];
        // $actual = ESObject::fold(["hello" => "world"])->setHello("chat", false);
        // // $this->assertEquals($obj->hello, $actual->hello);

        // $this->assertEquals($obj->hello, $actual->helloUnfolded());
    }

    public function testTransportabilitySetGetIssetAndUnset()
    {
        $obj = new \stdClass();
        $obj->hello = ["world", "chat"];

        // $object = Shoop::object([]);
        // $object->hello = ["world", "chat"];

        // $this->assertEquals($obj, $object->unfold());
        // $this->assertEquals($obj->hello, $object->hello);

        // $this->assertTrue(isset($object->hello));
        // $this->assertFalse(isset($object->goodbye));

        unset($object->hello);
        $this->assertFalse(isset($object->hello));

        // $expected = ["world", "chat"];
        // $object = Shoop::object([])
        //     ->plus("world", "hello")
        //     ->set("chat", "hello", false)
        //     ->get("hello");
        // $this->assertEquals($expected, $object);

        // TODO: Need more tests to verify getting in all the ways
    }

    public function testPhpTransportabilityArrayAccess()
    {
        // 2x
        // $object = Shoop::object([])
        //     ->plus("world", "hello")
        //     ->set("chat", "hello", false);
        // $this->assertFalse(empty($object));

        $objectNull = Shoop::object([]);
        $this->assertTrue(empty($objectNull[0]));

        // $this->assertEquals(["world", "chat"], $object["hello"]);

        $object = Shoop::object([]);
        $object->hello = ["world", "chat"];
        $this->assertEquals(["world", "chat"], $object->hello);

        // unset($object["hello"]);
        // $this->assertNull($object["hello"]);
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
