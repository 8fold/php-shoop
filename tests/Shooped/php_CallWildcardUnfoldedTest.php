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
 * Shoop leverages the PHP `__call()` magic method to allow for a few wildcard simplifications.
 *
 * If a method returns a Shoop type and add the "*Unfolded" suffix to the method name, it will automatically call `unfold()` on the result.
 *
 * You may also use `getUnfolded()` to automatically unfold things you would call using `get()`.
 *
 * @declared none
 *
 * @defined Eightfold\Shoop\Interfaces\ShoopedImp
 *
 * @overridden none
 *
 * @return multiple
 */
class php_CallWildcardUnfoldedTest extends TestCase
{
    public function testESArray()
    {
        $expected = [true];
        $result = ESArray::fold([true])->getUnfolded(0);
        $this->assertTrue($result);
    }

    public function testESBool()
    {
        $expected = [true];
        $actual = ESBool::fold(true)->arrayUnfolded();
        $this->assertEquals($expected, $actual);
    }

    public function testESDictionary()
    {
        $base = ["key" => false];
        $actual = ESDictionary::fold($base)->getUnfolded("key");
        $this->assertFalse($actual);
    }

    public function testESInt()
    {
        $expected = true;
        $actual = ESInt::fold(1)->boolUnfolded();
        $this->assertEquals($expected, $actual);
    }

    public function testESJson()
    {
        $actual = ESJson::fold('{"test":true}')->testUnfolded();
        $this->assertTrue($actual);
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->test = false;
        $actual = ESObject::fold($base)->testUnfolded();
        $this->assertFalse($actual);
    }

    public function testESString()
    {
        $expected = "puos tebahpla";
        $actual = ESString::fold("alphabet soup")->toggleUnfolded();
        $this->assertEquals($expected, $actual);
    }
}
