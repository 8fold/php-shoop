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
 * The `string()` method converts the Shoop type to a PHP string representation.
 *
 * @return Eightfold\Shoop\ESString
 */
class StringTest extends TestCase
{
    /**
     * @see PhpIndexedArray::toString
     */
    public function testESArray()
    {
        $expected = "Array()";

        $actual = ESArray::fold([])->string();
        $this->assertEquals($expected, $actual->unfold());

        $expected = "Array([0] => testing)";

        $actual = ESArray::fold(['testing'])->string();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpBool::toString
     */
    public function testESBool()
    {
        $expected = "true";

        $actual = ESBool::fold(true)->string();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpAssociativeArray::toString
     */
    public function testESDictionary()
    {
        $expected = "Dictionary()";

        $actual = ESDictionary::fold([])->string();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpInt::toString
     */
    public function testESInt()
    {
        $expected = "1";

        $actual = ESInt::fold(1)->string();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpJson::toString
     */
    public function testESJson()
    {
        $expected = '{"test":"test"}';

        $actual = ESJson::fold($expected)->string();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpObject::toString
     */
    public function testESObject()
    {
        $expected = "stdClass Object()";

        $actual = ESObject::fold(new \stdClass())->string();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESString The same value.
     */
    public function testESString()
    {
        $expected = "hello";

        $actual = ESString::fold("hello")->string();
        $this->assertEquals($expected, $actual->unfold());
    }
}
