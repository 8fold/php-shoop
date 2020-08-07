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
 * The `get` and `Unfolded` modifiers can be used together, surrounding the method to call or the member to get.
 *
 * @return mixed The return value of the method will be unfolded, returning it to a `PHP type` or the class it started as.
 *
 */
class php_CallWildcardGetUnfoldedTest extends TestCase
{
    public function testESArray()
    {
        $expected = [true];
        $result = ESArray::fold([true])->get0Unfolded();
        $this->assertTrue($result);
    }

    public function testESBool()
    {
        $expected = [true];
        $actual = ESBool::fold(true)->arrayUnfolded();
        $this->assertEquals($expected, $actual);

        $actual = ESBool::fold(true)->getArrayUnfolded();
        $this->assertEquals($expected, $actual);
    }

    public function testESDictionary()
    {
        $base = ["member" => false];
        $actual = ESDictionary::fold($base)->member;
        $this->assertFalse($actual);
    }

    public function testESInt()
    {
        $base = ESInt::fold(1);

        $expected = true;
        $actual = $base->bool;
        $this->assertEquals($expected, $actual);

        $expected = 1;
        $actual = $base->i1;
        $this->assertEquals($expected, $actual);
    }

    public function testESJson()
    {
        $base = ESJson::fold('{"test":true}');

        $actual = $base->test;
        $this->assertTrue($actual);

        // $actual = $base->hasTrue;
        // $this->assertTrue($actual);

        // $actual = $base->hasTest;
        // $this->assertTrue($actual);
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->test = false;
        $actual = ESObject::fold($base)->getTestUnfolded();
        $this->assertFalse($actual);
    }

    public function testESString()
    {
        $expected = " ";
        $actual = ESString::fold("alphabet soup")->get8Unfolded();
        $this->assertEquals($expected, $actual);
    }
}
