<?php

namespace Eightfold\Shoop\Tests\Helpers;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Helpers\SymfonyYaml;

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

class SymfonyTypeJugglingTest extends TestCase
{
// -> Yaml

    /**
     * @return array
     */
    public function testYamlToIndexedArray()
    {
        $expected = ["world"];
        $actual = SymfonyYaml::toIndexedArray("hello: world");
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return bool
     */
    public function testYamlToBool()
    {
        $expected = true;
        $actual = SymfonyYaml::toBool("hello: world");
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public function testYamlToAssociativeArray()
    {
        $expected = ["hello" => "world"];
        $actual = SymfonyYaml::toAssociativeArray("hello: world");
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return int
     */
    public function testYamlToInt()
    {
        $expected = 2;
        $actual = SymfonyYaml::toInt("hello: world\ngoodbye: something");
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return Json
     */
    public function testYamlToJson()
    {
        $expected = '{"hello":"world"}';
        $actual = SymfonyYaml::toJson("hello: world");
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return object
     */
    public function testYamlToObject()
    {
        $expected = new \stdClass();
        $expected->hello = "world";

        $actual = SymfonyYaml::toObject("hello: world");
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return Original value.
     */
    public function testYamlToString()
    {
        $this->assertFalse(false);
    }
}
