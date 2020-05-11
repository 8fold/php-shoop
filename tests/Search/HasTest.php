<?php

namespace Eightfold\Shoop\Tests\Search;

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
 * The `has()` method ehcks to see if the given value exists for any member/key/index of the `Shoop type`.
 *
 * @return Eightfold\Shoop\ESBool
 */
class HasTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->has("world");
        $this->assertTrue($actual->unfold());

        $actual = ESArray::fold($base)->hasMember(0);
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
        $base = ["key" => "value"];
        $actual = ESDictionary::fold($base)->has("value");
        $this->assertTrue($actual->unfold());

        $actual = ESDictionary::fold($base)->hasMember("key");
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
        $base = '{"member":"value", "member2":"value2", "member3":"value3"}';
        $actual = ESJson::fold($base)->has("value3");
        $this->assertTrue($actual->unfold());

        $actual = ESJson::fold($base)->hasMember("member2");
        $this->assertTrue($actual->unfold());

        $base = '{"events":{"2020":{"5":{"20":[{"title": "Event at Meetup"}]}}}}';
        $actual = ESJson::fold($base)->getEvents()->hasMember("2020");
        $this->assertTrue($actual->unfold());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->testMember = "test";

        $actual = ESObject::fold($base)->has("test");
        $this->assertTrue($actual->unfold());

        $actual = ESObject::fold($base)->hasMember("testMember");
        $this->assertTrue($actual->unfold());
    }

    public function testESString()
    {
        $actual = ESString::fold("a")->has("b");
        $this->assertFalse($actual->unfold());

        $actual = ESString::fold("b")->has("b");
        $this->assertTrue($actual->unfold());
    }
}
