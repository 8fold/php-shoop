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
 * @overridden Eightfold\Shoop\ESAray
 *
 * @return multiple
 */
class MagicCallWildcardSetTest extends TestCase
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
     * Equivalent to calling `unfold()` regardless of argument value.
     */
    public function testESBool()
    {
        $this->assertFalse(true);
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
     * Equivalent to calling `unfold()` regardless of argument value.
     */
    public function testESInt()
    {
        $base = 10;
        $actual = ESInt::fold($base)->get();
        $this->assertEquals($base, $actual->unfold());
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
