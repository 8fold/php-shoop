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
    ESTuple,
    ESString
};
/**
 * The `__toString()` method from the PHP standard library is available on all Shoop types. Therefore, all Shoop types can be used with `print`, `echo`, and similar methods from the PHP standard library.
 *
 * @return string
 */
class php_ToStringTest extends TestCase
{
    public function ESArray()
    {
        $expected = "Array()";

        $actual = ESArray::fold([]);
        $this->assertEquals($expected, $actual);

        $expected = "Array([0] => testing)";

        $actual = ESArray::fold(['testing']);
        $this->assertEquals($expected, $actual);
    }

    public function ESBoolean()
    {
        $expected = "true";

        $actual = ESBoolean::fold(true);
        $this->assertEquals($expected, $actual);
    }

    public function ESDictionary()
    {
        $expected = "Dictionary()";

        $actual = ESDictionary::fold([]);
        $this->assertEquals($expected, $actual);
    }

    public function ESInteger()
    {
        $expected = "1";

        $actual = ESInteger::fold(1);
        $this->assertEquals($expected, $actual);
    }

    public function ESJson()
    {
        $expected = '{"test":"test"}';

        $actual = ESJson::fold($expected);
        $this->assertEquals($expected, $actual);
    }

    public function ESTuple()
    {
        $expected = "stdClass Object()";

        $actual = ESTuple::fold(new \stdClass());
        $this->assertEquals($expected, $actual);
    }

    public function ESString()
    {
        $expected = "hello";

        $actual = ESString::fold("hello");
        $this->assertEquals($expected, $actual);
    }
}
