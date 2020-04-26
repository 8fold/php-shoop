<?php
namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\ESJson;

class JsonTest extends TestCase
{
    public function testCanInitialize()
    {
        $json = ESJson::fold('{"json":2}');
        $this->assertNotNull($json);

        $json = Shoop::json('{"json":2}');
        $this->assertTrue(is_a($json, ESJson::class));

        $json = Shoop::this('{"json":2}');
        $this->assertTrue(is_a($json, ESJson::class));

        $json = Shoop::string(__DIR__)
            ->divide("/")
            ->plus("data", "local-business.json")
            ->join("/")
            ->start("/")
            ->pathContent()
            ->json();
        $this->assertTrue(Type::is($json, ESJson::class));
    }

    public function testTypeJuggling()
    {
        $expected = '{"hello":"world"}';
        $json = Shoop::json($expected);
        $actual = $json->string();
        $this->assertEquals($expected, $actual);

        $actual = $json->array();
        $this->assertEquals(['world'], $actual->unfold());

        $actual = $json->dictionary();
        $this->assertEquals(["hello" => "world"], $actual->unfold());

        $expected = new \stdClass();
        $expected->hello = "world";
        $actual = $json->object();
        $this->assertEquals($expected, $actual->unfold());

        $actual = $json->int();
        $this->assertEquals(1, $actual->unfold());
    }

    public function testMathLanguage()
    {
        // $base = new \stdClass();

        // $actual = Shoop::json("{}")->multiply(3);
        // $this->assertEquals([$base, $base, $base], $actual->unfold());

        $actual = Shoop::json("{}")
            ->plus("hello", "world")
            ->get("hello");
        $this->assertEquals("world", $actual->unfold());

        $actual = Shoop::json("{}")
            ->plus("hello", "world")
            ->minus("hello");
        $this->assertEquals("{}", $actual->unfold());

        // $copy = $base;
        // $copy->hello = "world";
        // $actual = Shoop::json("{}")
        //     ->plus("hello", $copy)
        //     ->string();
        // $this->assertEquals('{"hello":{"hello":"world"}}', $actual->unfold());

        // $actual = Shoop::json("{}")->plus("hello", [1, 2, 3, 4])->string();
        // $this->assertEquals('{"hello":[1,2,3,4]}', $actual->unfold());
    }

    public function testComparisons()
    {
        $base = '{"hello":{"world":"!"}}';
        $actual = Shoop::json($base)->get("hello")->get("world")->is("!");
        $this->assertTrue($actual->unfold());
    }

    public function testOther()
    {
        $actual = Shoop::json('{"hello":"world!"}')->get("hello");
        $this->assertEquals("world!", $actual);
    }
}
