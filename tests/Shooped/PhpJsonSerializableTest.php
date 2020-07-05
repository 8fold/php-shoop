<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    Shoop,
    ESArray,
    Helpers\Type
};

class PhpJsonSerializableTest extends TestCase
{
    /**
     * @return Eightfold\Shoop\ESArray The original value.
     */
    public function testESArray()
    {
        $expected = "{}";
        $actual = json_encode(ESArray::fold([]));

        $this->assertEquals($expected, $actual);
    }

    /**
     * @see PhpTypeJuggle::boolToIndexedArray
     */
    public function testESBool()
    {
        $expected = '{"true":true,"false":false}';
        $actual = json_encode(Shoop::bool(true));
        $this->assertEquals($expected, $actual);
    }

    /**
     * @see PhpTypeJuggle::associativeArrayToIndexedArray
     */
    public function testESDictionary()
    {
        $expected = '{}';
        $actual = json_encode(Shoop::dictionary([]));
        $this->assertEquals($expected, $actual);
    }

    /**
     * @see PhpTypeJuggle::intToIndexedArray
     */
    public function testESInt()
    {
        $expected = '{"i0":0,"i1":1}';
        $actual = json_encode(Shoop::int(1));
        $this->assertEquals($expected, $actual);
    }

    /**
     * An instance of ESJson can be passed directly to the `json_decoded()` function in the PHP standard library.
     *
     * @return \stdClass
     */
    public function testESJson()
    {
        $json = Shoop::json('{"member":"test"}');
        $expected = new \stdClass();
        $expected->member = "test";
        $expected = json_encode($expected);
        $actual = json_encode($json);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @see PhpTypeJuggle::objectToIndexedArray
     */
    public function testESObject()
    {
        $expected = "{}";
        $actual = json_encode(Shoop::object(new \stdClass()));
        $this->assertEquals($expected, $actual);
    }

    /**
     * @see PhpTypeJuggle::stringToIndexedArray
     */
    public function testESString()
    {
        $expected = '{"string":"hello"}';
        $actual = json_encode(Shoop::string("hello"));
        $this->assertEquals($expected, $actual);
    }
}
