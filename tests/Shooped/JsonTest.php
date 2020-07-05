<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\{
    Shoop,
    ESArray,
    ESBool,
    ESDictionary,
    ESInt,
    ESJson,
    ESObject,
    ESString
};

/**
 * The `json()` method converts the `Shoop type` to the JSON respresentation.
 *
 * @return Eightfold\Shoop\ESString In JSON.
 */
class JsonTest extends TestCase
{
    /**
     * @see PhpTypeJuggle::indexedArrayToJson
     */
    public function testESArray()
    {
        $expected = "{}";

        $actual = ESArray::fold([])->json();
        $this->assertEquals($expected, $actual->unfold());

        $expected = "Array([0] => testing)";

        $actual = ESArray::fold(['testing'])->string();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpTypeJuggle::boolToJson
     */
    public function testESBool()
    {
        $expected = '{"true":true,"false":false}';
        $actual = ESBool::fold(true)->json();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpTypeJuggle::associativeArrayToJson
     */
    public function testESDictionary()
    {
        $expected = '{}';
        $actual = ESDictionary::fold([])->json();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpTypeJuggle::intToJson
     */
    public function testESInt()
    {
        $expected = '{"i0":0,"i1":1}';
        $actual = ESInt::fold(1)->json();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESJson The same value.
     */
    public function testESJson()
    {
        $expected = '{"test":"test"}';
        $actual = ESJson::fold($expected)->json();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpTypeJuggle::objectToJson
     */
    public function testESObject()
    {
        $expected = "{}";
        $actual = ESObject::fold(new \stdClass())->json();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpTypeJuggle::stringToJson
     */
    public function testESString()
    {
        $expected = '{"scalar":"hello"}';
        $actual = ESString::fold('{"scalar":"hello"}')->json();
        $this->assertEquals($expected, $actual->unfold());
    }
}
