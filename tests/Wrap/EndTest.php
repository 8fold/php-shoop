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
 * The `isGreaterThan()` performs PHP greater than comparison (>) to determine if the initial value is greater than the compared value.
 *
 * Note: Expects both values to be of the same type, Shoop type, or combination (cannot compare an `int` to a `bool`, for example).
 *
 * @declared Eightfold\Shoop\Interfaces\Compare
 *
 * @defined Eightfold\Shoop\Traits\CompareImp
 *
 * @overridden
 *
 * @return Eightfold\Shoop\ESBool
 */
class EndTest extends TestCase
{
    public function testESArray()
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
    public function testESBool()
    {
        $this->assertFalse(false);
    }

    public function testESDictionary()
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
    public function testESInt()
    {
        $this->assertFalse(false);
    }

    public function testESJson()
    {
        $base = '{"member2":"value2", "member3":"value3"}';

        $expected = json_encode(["member2" => "value2", "member3" => "value3", "member" => "value"]);
        $actual = ESJson::fold($base)->end("value", "member");
        $this->assertEquals(ESJson::class, get_class($actual));
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->testMember = new \stdClass();
        $base->testMember2 = 2;

        $expected = $base;
        $actual = Shoop::object(new \stdClass())->end(new \stdClass(), "testMember", 2, "testMember2");
        $this->assertEquals(ESObject::class, get_class($actual));
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESString()
    {
        $expected = "Hello, World!";
        $actual = Shoop::string("Hello")->end(", World!");
        $this->assertEquals(ESString::class, get_class($actual));
        $this->assertEquals($expected, $actual);
    }
}
