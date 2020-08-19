<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;



use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    ESBoolean,
    ESDictionary,
    ESInteger,
    ESJson,
    ESObject,
    ESString
};

/**
 * The `json()` method converts the Shoop type to a representation using JSON.
 *
 * @return Eightfold\Shoop\FluentTypes\ESString In JSON.
 */
class JsonTest extends TestCase
{
    /**
     * @see PhpIndexedArray::toJson
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
     * @see PhpBool::toJson
     */
    public function testESBoolean()
    {
        $expected = '{"true":true,"false":false}';
        $actual = ESBoolean::fold(true)->json();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpAssociativeArray::toJson
     */
    public function testESDictionary()
    {
        $expected = '{}';
        $actual = ESDictionary::fold([])->json();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpInt::toJson
     */
    public function testESInteger()
    {
        $expected = '{"i0":0,"i1":1}';
        $actual = ESInteger::fold(1)->json();
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
     * @see PhpObject::toJson
     */
    public function testESObject()
    {
        $expected = "{}";
        $actual = ESObject::fold(new \stdClass())->json();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpString::toJson
     */
    public function testESString()
    {
        $expected = '{"scalar":"hello"}';
        $actual = ESString::fold('{"scalar":"hello"}')->json();
        $this->assertEquals($expected, $actual->unfold());
    }
}
