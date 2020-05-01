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
 * The `string()` method converts the 8fold type to an `ESString` type.
 *
 * Typpically uses PHP's `print_r()` after using `unfold()` on the value.
 *
 * This allows each Shoop type to be treated as a PHP `string`, which means `string()` is an alias for the PHP `__toString()` magic method.
 *
 * @declared Eightfold\Shoop\Interfaces\Shooped
 *
 * @defined Eightfold\Shoop\Traits\ShoopedImp
 *
 * @overridden Eightfold\Shoop\ESBool, Eightfold\Shoop\ESInt, Eightfold\Shoop\ESJson, Eightfold\Shoop\ESString
 *
 * @return Eightfold\Shoop\ESString
 */
class JsonTest extends TestCase
{
    public function testESArray()
    {
        $expected = "{}";

        $actual = ESArray::fold([])->json();
        $this->assertEquals($expected, $actual->unfold());

        $expected = "Array([0] => testing)";

        $actual = ESArray::fold(['testing'])->string();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESBool()
    {
        $expected = '{"true":true,"false":false}';

        $actual = ESBool::fold(true)->json();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESDictionary()
    {
        $expected = '{}';

        $actual = ESDictionary::fold([])->json();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * Equivalent to `dicitonary()->ogject()->json()`.
     */
    public function testESInt()
    {
        $expected = '{"i0":0,"i1":1}';

        $actual = ESInt::fold(1)->json();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESJson()
    {
        $expected = '{"test":"test"}';

        $actual = ESJson::fold($expected)->json();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESObject()
    {
        $expected = "{}";

        $actual = ESObject::fold(new \stdClass())->json();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESString()
    {
        $expected = '{"scalar":"hello"}';

        $actual = ESString::fold('{"scalar":"hello"}')->json();
        $this->assertEquals($expected, $actual->unfold());
    }
}
