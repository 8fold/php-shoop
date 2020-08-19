<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    Helpers\Type
};

/**
 * The `jsonSerialize()` method from the `JsonSerializable` interface allows the instance of a Shoop type to be passed to the `json_encode()` function from the PHP standard library. All Shoop types conform to the `JsonSerializable` interface.
 */
class PhpJsonSerializableTest extends TestCase
{
    public function testESArray()
    {
        $expected = "{}";
        $actual = json_encode(ESArray::fold([]));

        $this->assertEquals($expected, $actual);
    }

    public function testESBoolean()
    {
        $expected = '{"true":true,"false":false}';
        $actual = json_encode(Shoop::bool(true));
        $this->assertEquals($expected, $actual);
    }

    public function testESDictionary()
    {
        $expected = '{}';
        $actual = json_encode(Shoop::dictionary([]));
        $this->assertEquals($expected, $actual);
    }

    public function testESInteger()
    {
        $expected = '{"i0":0,"i1":1}';
        $actual = json_encode(Shoop::int(1));
        $this->assertEquals($expected, $actual);
    }

    public function testESJson()
    {
        $json = Shoop::json('{"member":"test"}');
        $expected = new \stdClass();
        $expected->member = "test";
        $expected = json_encode($expected);
        $actual = json_encode($json);
        $this->assertEquals($expected, $actual);
    }

    public function testESObject()
    {
        $expected = "{}";
        $actual = json_encode(Shoop::object(new \stdClass()));
        $this->assertEquals($expected, $actual);
    }

    public function testESString()
    {
        $expected = '{"string":"hello"}';
        $actual = json_encode(Shoop::string("hello"));
        $this->assertEquals($expected, $actual);
    }
}
