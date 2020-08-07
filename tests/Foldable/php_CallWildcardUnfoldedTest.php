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
 * The `*Unfolded()` modifier can be added to the end of any method call to return the PHP type value.
 *
 * @return mixed
 *   - If the value is a PHP type, it will be converted to the equivalent Shoop type.
 *   - If the value conforms to the Shooped interface, the instance is returned.
 *   - Otherwise, the raw value is returned (instances of non-Shoop types or class, for example.)
 *
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
        $base = ["member" => false];
        $actual = ESDictionary::fold($base)->getUnfolded("member");
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
