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
 * The `get` and `Unfolded` modifiers can be used together, surrounding the method to call or the member to get.
 *
 * @return mixed The return value of the method will be unfolded, returning it to a `PHP type` or the class it started as.
 *
 */
class php_CallWildcardGetUnfoldedTest extends TestCase
{
    public function ESArray()
    {
        $expected = [true];
        $result = ESArray::fold([true])->get0Unfolded();
        $this->assertTrue($result);
    }

    public function ESBoolean()
    {
        $expected = [true];
        $actual = ESBoolean::fold(true)->arrayUnfolded();
        $this->assertEquals($expected, $actual);

        $actual = ESBoolean::fold(true)->getArrayUnfolded();
        $this->assertEquals($expected, $actual);
    }

    public function ESDictionary()
    {
        $base = ["member" => false];
        $actual = ESDictionary::fold($base)->member;
        $this->assertFalse($actual);
    }

    public function ESInteger()
    {
        $base = ESInteger::fold(1);

        $expected = true;
        $actual = $base->bool;
        $this->assertEquals($expected, $actual);

        $expected = 1;
        $actual = $base->i1;
        $this->assertEquals($expected, $actual);
    }

    public function ESJson()
    {
        $base = ESJson::fold('{"test":true}');

        $actual = $base->test;
        $this->assertTrue($actual);

        // $actual = $base->hasTrue;
        // $this->assertTrue($actual);

        // $actual = $base->hasTest;
        // $this->assertTrue($actual);
    }

    public function ESTuple()
    {
        $base = new \stdClass();
        $base->test = false;
        $actual = ESTuple::fold($base)->getTestUnfolded();
        $this->assertFalse($actual);
    }

    public function ESString()
    {
        $expected = " ";
        $actual = ESString::fold("alphabet soup")->get8Unfolded();
        $this->assertEquals($expected, $actual);
    }
}
