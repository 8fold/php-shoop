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
 * The `end()` method appends the given array, dictionary-like, and string object with the specified value.
 *
 * @return multiple The same `Shoop type` with the additional values.
 */
class EndTest extends TestCase
{
    public function ESArray()
    {
        $base = ["hello", "world"];

        $expected = ["hello", "world", "something"];
        $actual = Shoop::array($base)->end("something");
        $this->assertEquals(ESArray::class, get_class($actual));
        $this->assertEquals($expected, $actual->unfold());
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
        $base = ["first" => 1, "second" => 2];

        $expected = ["first" => 1, "second" => 2, "zero" => 0];
        $actual = ESDictionary::fold($base)->end(0, "zero");
        $this->assertEquals(ESDictionary::class, get_class($actual));
        $this->assertEquals($expected, $actual->unfold());
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
        $base = '{"member2":"value2", "member3":"value3"}';

        $expected = json_encode(["member2" => "value2", "member3" => "value3", "member" => "value"]);
        $actual = ESJson::fold($base)->end("value", "member");
        $this->assertEquals(ESJson::class, get_class($actual));
        $this->assertEquals($expected, $actual->unfold());
    }

    public function ESTuple()
    {
        $base = new \stdClass();
        $base->testMember = new \stdClass();
        $base->testMember2 = 2;

        $expected = $base;
        $actual = Shoop::object(new \stdClass())->end(new \stdClass(), "testMember", 2, "testMember2");
        $this->assertEquals(ESTuple::class, get_class($actual));
        $this->assertEquals($expected, $actual->unfold());
    }

    public function ESString()
    {
        $expected = "Hello, World!";
        $actual = Shoop::string("Hello")->end(", World!");
        $this->assertEquals(ESString::class, get_class($actual));
        $this->assertEquals($expected, $actual);
    }
}
