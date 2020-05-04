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
 * All Shoop types can be used as a PHP string without calling `unfold()`.
 *
 * @see Eightfold\Shoop\Tests\ToStringTest
 *
 * @declared Eightfold\Shoop\Interfaces\Shooped
 *
 * @defined Eightfold\Shoop\Traits\ShoopedImp
 *
 * @overridden none
 *
 * @return string Calling `string()->unfold()`
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

    public function testESBool()
    {
        $expected = "true";

        $actual = ESBool::fold(true);
        $this->assertEquals($expected, $actual);
    }

    public function testESDictionary()
    {
        $expected = "Array()";

        $actual = ESDictionary::fold([]);
        $this->assertEquals($expected, $actual);
    }

    public function testESInt()
    {
        $expected = "1";

        $actual = ESInt::fold(1);
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
