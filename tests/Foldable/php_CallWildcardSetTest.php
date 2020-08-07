<?php

namespace Eightfold\Shoop\Tests\Foldable;

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
 * The `set*()` method in conjunction with the `__call()` function from the PHP standard library allows you to use a shorthand for `set()` with a Shoop type that has string-based members.
 *
 * By prefixing the desired member with "set" you are calling the `set()` method where the string following "set" indicates the member and the first argument is the desired value.
 *
 * If the member does not exist, it will be created.
 *
 * The second value is a boolean and can be a Shoop type or PHP bolean and indicates whether a preexisting value for the member should be overwritten. The default is true.
 *
 * @return mixed It will be an insstance of the same Shoop type with the specified adjustment to the specified member.
 *
 */
class php_CallWildcardSetTest extends TestCase
{
    public function testESArray()
    {
        $base = [];

        $expected = [true];
        $actual = ESArray::fold($base)->set(true, 0);
        $this->assertEquals($expected, $actual->unfold());

        $expected = [false];
        $actual = ESArray::fold([true])->set(false, 0, false);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * Equivalent to creating a new instance with a new value.
     */
    public function testESBool()
    {
        $base = true;
        $actual = ESBool::fold($base)->set(false);
        $this->assertFalse($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = ["member" => false];
        $expected = ["member" => true];
        $actual = ESDictionary::fold($base)->setMember(true);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * Equivalent to creating a new instance with a new value.
     */
    public function testESInt()
    {
        $base = 10;
        $expected = 5;
        $actual = ESInt::fold($base)->set(5);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESJson()
    {
        $expected = '{"test":true}';
        $actual = ESJson::fold('{}')->setTest(true);
        $this->assertEquals($expected, $actual);
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->test = false;
        $actual = ESObject::fold($base)->setTest(true, true);
        $this->assertTrue($actual->test()->unfold());
    }

    /**
     * Equivalent to creating a new instance with a new value.
     */
    public function testESString()
    {
        $base = "alphabet soup";
        $actual = ESString::fold($base)->get(1);
        $this->assertEquals("l", $actual->unfold());
    }
}
