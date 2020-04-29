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
 * You can prefix any method call with "set", which is mainly used for interacting with arrays or objects with members.
 *
 * When creating `set()` on a Shoop type, the signature should be `set($value, $key = null, $overwrite = true)`.
 *
 * Having `value` first is what allows Shoop types that are not easy to convert to array still able to cleanly use `set()` and matches the pattern used in `each()` as well.
 *
 * @declared none
 *
 * @defined Eightfold\Shoop\Interfaces\ShoopedImp
 *
 * @overridden Eightfold\Shoop\ESBool, Eightfold\Shoop\ESInt, Eightfold\Shoop\ESString
 *
 * @return multiple
 */
class php_CallWildcardSetTest extends TestCase
{
    public function testESArray()
    {
        $base = [];

        $expected = [true];
        $result = ESArray::fold($base)->set(true, 0);
        $this->assertTrue($result->get(0)->unfold());

        $expected = [false];
        $result = ESArray::fold([true])->set(false, 0, true);
        $this->assertTrue($result->get(0)->unfold());
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
        $base = ["key" => false];
        $actual = ESDictionary::fold($base)->getKey();
        $this->assertFalse($actual->unfold());
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
        $base = '{"test":true}';
        $actual = ESJson::fold('{}')->setTest(true);
        $this->assertTrue($actual->getTest()->unfold());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->test = false;
        $actual = ESObject::fold($base)->setTest(true, true);
        $this->assertTrue($actual->test());
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
