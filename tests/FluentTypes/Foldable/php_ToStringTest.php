<?php

namespace Eightfold\Shoop\Tests\Foldable;

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
 * The `__toString()` method from the PHP standard library is available on all Shoop types. Therefore, all Shoop types can be used with `print`, `echo`, and similar methods from the PHP standard library.
 *
 * @return string
 */
class php_ToStringTest extends TestCase
{
    public function testESArray()
    {
        $expected = "Array()";

        $actual = ESArray::fold([]);
        $this->assertEquals($expected, $actual);

        $expected = "Array([0] => testing)";

        $actual = ESArray::fold(['testing']);
        $this->assertEquals($expected, $actual);
    }

    public function testESBoolean()
    {
        $expected = "true";

        $actual = ESBoolean::fold(true);
        $this->assertEquals($expected, $actual);
    }

    public function testESDictionary()
    {
        $expected = "Dictionary()";

        $actual = ESDictionary::fold([]);
        $this->assertEquals($expected, $actual);
    }

    public function testESInteger()
    {
        $expected = "1";

        $actual = ESInteger::fold(1);
        $this->assertEquals($expected, $actual);
    }

    public function testESJson()
    {
        $expected = '{"test":"test"}';

        $actual = ESJson::fold($expected);
        $this->assertEquals($expected, $actual);
    }

    public function testESObject()
    {
        $expected = "stdClass Object()";

        $actual = ESObject::fold(new \stdClass());
        $this->assertEquals($expected, $actual);
    }

    public function testESString()
    {
        $expected = "hello";

        $actual = ESString::fold("hello");
        $this->assertEquals($expected, $actual);
    }
}
