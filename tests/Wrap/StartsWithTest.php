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
 * The `startsWith()` method checks that the first atomic pieces of arrays, dictionary-like, and string objects end with the specified value.
 *
 * @return Eightfold\Shoop\ESBool
 */
class StartsWithTest extends TestCase
{
    public function testESArray()
    {
        $base = ["something", "hello", "world"];

        $actual = Shoop::array($base)->startsWith("something");
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

        $actual = ESDictionary::fold($base)->startsWith(0, "zero", 1, "first");
        $this->assertEquals(ESBool::class, get_class($actual));
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

        $actual = ESJson::fold($base)->startsWith("value", "member");
        $this->assertEquals(ESBool::class, get_class($actual));
        $this->assertTrue($actual->unfold());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->testMember = "test";
        $base->testMember2 = 2;

        $actual = Shoop::object($base)->startsWith("test", "testMember");
        $this->assertEquals(ESBool::class, get_class($actual));
        $this->assertTrue($actual->unfold());
    }

    public function testESString()
    {
        $base = "Hello, World!";
        $actual = Shoop::string($base)->startsWith("Hello, ");
        $this->assertEquals(ESBool::class, get_class($actual));
        $this->assertTrue($actual->unfold());
    }
}
