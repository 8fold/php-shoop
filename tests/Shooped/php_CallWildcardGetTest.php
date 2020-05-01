<?php

namespace Eightfold\Shoop\Tests\Shooped;

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
 * Shoop leverages the PHP `__call()` magic method to allow for a few wildcard simplifications.
 *
 * You can prefix any method call with "get", which is mainly used for interacting with arrays or objects with members.
 *
 * Shoop will attempt to return a Shoop type whenever possible.
 *
 * So, `getArray()` is equivalent to calling `array()`. `get{MemberName}()` is equivalent to `getMember('MemberName')`. And so on.
 *
 * See also anonymous getter methods.
 *
 * @declared none
 *
 * @defined Eightfold\Shoop\Interfaces\ShoopedImp
 *
 * @overridden Eightfold\Shoop\ESAray
 *
 * @return multiple
 */
class php_CallWildcardGetTest extends TestCase
{
    public function testESArray()
    {
        $base = [false, true];
        $array = ESArray::fold($base);
        $this->assertTrue($array->get(1)->unfold());

        $actual = $array->get(0);
        $this->assertFalse($actual->unfold());

        // Which is equivalent to:
        $actual = $array->getFirst();
        $this->assertFalse($actual->unfold());

        // Which is equivalent to:
        $actual = $array->first();
        $this->assertFalse($actual->unfold());
    }

    /**
     * Equivalent to calling `unfold()` regardless of argument value.
     */
    public function testESBool()
    {
        $base = true;
        $actual = ESBool::fold($base)->get();
        $this->assertTrue($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = ["key" => false];
        $actual = ESDictionary::fold($base)->getKey();
        $this->assertFalse($actual->unfold());
    }

    /**
     * Equivalent to calling `unfold()` regardless of argument value.
     */
    public function testESInt()
    {
        $base = 10;

        $expected = 0;
        $actual = ESInt::fold($base)->get();
        $this->assertEquals($expected, $actual->unfold());

        $expected = 9;
        $actual = ESInt::fold($base)->get(9);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESJson()
    {
        $base = '{"test":true}';
        $actual = ESJson::fold($base)->getTest();
        $this->assertTrue($actual->unfold());

        // Anonymous getter, as "test" is not defined on ESJson
        $actual = ESJson::fold($base)->test();
        $this->assertTrue($actual);
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->test = false;
        $actual = ESObject::fold($base)->getTest($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESString()
    {
        $base = "alphabet soup";
        $actual = ESString::fold($base)->get(1);
        $this->assertEquals("l", $actual->unfold());
    }
}
