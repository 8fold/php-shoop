<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    Type,
    ESArray,
    ESBool,
    ESDictionary,
    ESInt,
    ESJson,
    ESObject,
    ESString
};

/**
 * The `object()` method converts the 8fold type to an `ESObject` type.
 *
 * Typically this means using PHP to cast the value after calling `unfold()`
 *
 * @declared Eightfold\Shoop\Interfaces\Shooped
 *
 * @defined Eightfold\Shoop\Traits\ShoopedImp
 *
 * @overridden Eightfold\Shoop\ESBool, Eightfold\Shoop\ESJson
 *
 * @return ESObject
 */
class ToObjecctTest extends TestCase
{
    public function testESArray()
    {
        $expected = new \stdClass();
        $expected->i0 = "testing";

        $actual = ESArray::fold(['testing'])->object();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * Returns object with two properties: true and false.
     *
     * If the value was `true`, the property `true` will be `true`, and `false` will be `false`.
     *
     * If the value was `false`, the property `true` will be `false`,and `false` will be `true`.
     */
    public function testESBool()
    {
        $expected = new \stdClass();
        $expected->true = true;
        $expected->false = false;

        $actual = ESBool::fold(true)->object();
        $this->assertEquals($expected, $actual->unfold());

        $expected = new \stdClass();
        $expected->true = false;
        $expected->false = true;

        $actual = ESBool::fold(false)->object();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESDictionary()
    {
        $expected = new \stdClass();

        $actual = ESDictionary::fold([])->object();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESInt()
    {
        $expected = new \stdClass();
        $expected->i0 = 0;
        $expected->i1 = 1;

        $actual = ESInt::fold(1)->object();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * Essentially an alias for `object()` on ESDictionary.
     *
     * @see Eightfold\Shoop\ESDictionary `object()`
     *
     * @see Eightfold\Shoop\Tests\ToDictionaryTest testESJson
     */
    public function testESJson()
    {
        $expected = new \stdClass();
        $expected->test = "test";

        $actual = ESJson::fold('{"test":"test"}')->object();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESObject()
    {
        $expected = new \stdClass();

        $actual = ESObject::fold(new \stdClass())->object();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESString()
    {
        $expected = new \stdClass();
        $expected->scalar = "";

        $actual = ESString::fold("")->object();
        $this->assertEquals($expected, $actual->unfold());
    }
}
