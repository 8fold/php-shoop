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
    ESTuple,
    ESString
};

/**
 * The `string()` method converts the Shoop type to a PHP string representation.
 *
 * @return Eightfold\Shoop\FluentTypes\ESString
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
    public function testESBoolean()
    {
        $expected = "true";

        $actual = ESBoolean::fold(true)->string();
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
    public function testESInteger()
    {
        $expected = "1";

        $actual = ESInteger::fold(1)->string();
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
    public function testESTuple()
    {
        $expected = "stdClass Object()";

        $actual = ESTuple::fold(new \stdClass())->string();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\FluentTypes\ESString The same value.
     */
    public function testESString()
    {
        $expected = "hello";

        $actual = ESString::fold("hello")->string();
        $this->assertEquals($expected, $actual->unfold());
    }
}
