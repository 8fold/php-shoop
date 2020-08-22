<?php

namespace Eightfold\Shoop\Tests\Wrap;

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
 * @see startsWith() The returned value uses `toggle()` before being returned.
 *
 * @return Eightfold\Shoop\ESBoolean
 */
class DoesNotStartWithTest extends TestCase
{
    public function ESArray()
    {
        $base = ["something", "hello", "world"];

        $actual = Shoop::array($base)->doesNotStartWith("hello", "world");
        $this->assertEquals(ESBoolean::class, get_class($actual));
        $this->assertTrue($actual->unfold());
    }

    /**
     * @not
     */
    public function ESBoolean()
    {
        $this->assertFalse(false);
    }

    public function ESDictionary()
    {
        $base = ["zero" => 0, "first" => 1, "second" => 2];

        $actual = ESDictionary::fold($base)->doesNotStartWith(0, "zero", 1, "first");
        $this->assertEquals(ESBoolean::class, get_class($actual));
        $this->assertFalse($actual->unfold());
    }

    /**
     * @not
     */
    public function ESInteger()
    {
        $this->assertFalse(false);
    }

    public function ESJson()
    {
        $base = json_encode(["member" => "value", "member2" => "value2", "member3" => "value3"]);

        $actual = ESJson::fold($base)->doesNotStartWith("value3", "member3");
        $this->assertEquals(ESBoolean::class, get_class($actual));
        $this->assertTrue($actual->unfold());
    }

    public function ESTuple()
    {
        $base = new \stdClass();
        $base->testMember = "test";
        $base->testMember2 = 2;

        $actual = Shoop::object($base)->doesNotStartWith("test", "testMember");
        $this->assertEquals(ESBoolean::class, get_class($actual));
        $this->assertFalse($actual->unfold());
    }

    public function ESString()
    {
        $base = "Hello, World!";
        $actual = Shoop::string($base)->doesNotStartWith("World!");
        $this->assertEquals(ESBoolean::class, get_class($actual));
        $this->assertTrue($actual->unfold());
    }
}
