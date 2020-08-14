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
 * The `start()` method prepends the given array, dictionary-like, and string object with the specified value.
 *
 * @return multiple The same `Shoop type` with the additional values.
 */
class StartTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];

        $expected = ["something", "hello", "world"];
        $actual = Shoop::array($base)->start("something");
        $this->assertEquals(ESArray::class, get_class($actual));
        $this->assertEquals($expected, $actual->unfold());
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
        $base = ["first" => 1, "second" => 2];

        $expected = ["zero" => 0, "first" => 1, "second" => 2];
        $actual = ESDictionary::fold($base)->start(0, "zero");
        $this->assertEquals(ESDictionary::class, get_class($actual));
        $this->assertEquals($expected, $actual->unfold());
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
        $base = '{"member2":"value2", "member3":"value3"}';

        $expected = json_encode(["member" => "value", "member2" => "value2", "member3" => "value3"]);
        $actual = ESJson::fold($base)->start("value", "member");
        $this->assertEquals(ESJson::class, get_class($actual));
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->testMember = new \stdClass();
        $base->testMember2 = 2;

        $expected = $base;
        $actual = Shoop::object(new \stdClass())->start(new \stdClass(), "testMember", 2, "testMember2");
        $this->assertEquals(ESObject::class, get_class($actual));
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESString()
    {
        $expected = "Hello, World!";
        $actual = Shoop::string("World!")->start("Hello, ");
        $this->assertEquals(ESString::class, get_class($actual));
        $this->assertEquals($expected, $actual);
    }
}
