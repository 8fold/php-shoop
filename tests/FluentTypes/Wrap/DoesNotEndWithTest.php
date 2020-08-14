<?php

namespace Eightfold\Shoop\Tests\Wrap;

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
 * @see endsWith() The returned value uses `toggle()` before being returned.
 *
 * @return Eightfold\Shoop\ESBool
 */
class DoesNotEndWithTest extends TestCase
{
    public function testESArray()
    {
        $base = ["something", "hello", "world"];

        $actual = Shoop::array($base)->doesNotEndWith("something");
        $this->assertEquals(ESBool::class, get_class($actual));
        $this->assertTrue($actual->unfold());
    }

    /**
     * @not
     */
    public function testESBool()
    {
        $this->assertFalse(false);
    }

    public function testESDictionary()
    {
        $base = ["zero" => 0, "first" => 1, "second" => 2];

        $actual = ESDictionary::fold($base)->doesNotEndWith(0, "zero", 1, "first");
        $this->assertEquals(ESBool::class, get_class($actual));
        $this->assertTrue($actual->unfold());
    }

    /**
     * @not
     */
    public function testESInt()
    {
        $this->assertFalse(false);
    }

    public function testESJson()
    {
        $base = json_encode(["member" => "value", "member2" => "value2", "member3" => "value3"]);

        $actual = ESJson::fold($base)->doesNotEndWith("value3", "member3");
        $this->assertEquals(ESBool::class, get_class($actual));
        $this->assertFalse($actual->unfold());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->testMember = "test";
        $base->testMember2 = 2;

        $actual = Shoop::object($base)->doesNotEndWith("test", "testMember");
        $this->assertEquals(ESBool::class, get_class($actual));
        $this->assertTrue($actual->unfold());
    }

    public function testESString()
    {
        $base = "Hello, World!";
        $actual = Shoop::string($base)->doesNotEndWith("World!");
        $this->assertEquals(ESBool::class, get_class($actual));
        $this->assertFalse($actual->unfold());
    }
}
