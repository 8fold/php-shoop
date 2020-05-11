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
 * The `get()` method can be called directly and is a fall through for the `__call()` function from the PHP standard library.
 *
 * You can use `get()` directly, which takes an argument and will return the value of the member/key/index, if available; for ESBool and ESInt, the value is returned.
 *
 * You can `get*()` where "*" is the name of a method on the `Shoop type` or a string-based member/key, if available.
 *
 * You can also call a faux method, which is the name of a string-based member/key, which will then call `get()`, using the string as the argument.
 *
 * @return multiple If the value is a `PHP type`, it will be converted to the equivalent `Shoop type`. If the value coforms to the `Shooped interface`, the instance is returned. Otherwise, the raw value is returned (instances of `non-Shoop types or class`, for example.
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
