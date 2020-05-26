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
 * All `Shoop types` can be converted to an `ESArray` and `ESDictionary`; therefore, all `Shoop types` can be fed through `isset`.
 *
 * @return bool
 */
class php_IssetTest extends TestCase
{
    /**
     * Doesn't require a custom implementation, uses `ArrayAccess` methods.
     */
    public function testESArray()
    {
        $base = [];
        $array = ESArray::fold($base);
        $this->assertFalse(isset($array[0]));

        $base = ["hello"];
        $array = ESArray::fold($base);
        $this->assertTrue(isset($array[0]));
    }

    public function testESBool()
    {
        $actual = ESBool::fold(true);
        $this->assertTrue(isset($actual["false"]));
        $this->assertFalse(isset($actual["hello"]));
    }

    public function testESDictionary()
    {
        $actual = ESDictionary::fold(["member" => "value"]);
        $this->assertTrue(isset($actual["member"]));
    }

    public function testESInt()
    {
        $actual = ESInt::fold(10);
        $this->assertTrue(isset($actual[5]));
    }

    public function testESJson()
    {
        $expected = '{"test":"test"}';
        $actual = ESJson::fold($expected);
        $this->assertTrue(isset($actual->test));
    }

    public function testESObject()
    {
        $actual = ESObject::fold(new \stdClass());
        $this->assertFalse(isset($actu->hello));
    }

    public function testESString()
    {
        $actual = ESString::fold("hello");
        $this->assertTrue(isset($actual[3]));
    }
}
