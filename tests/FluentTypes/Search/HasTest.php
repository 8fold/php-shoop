<?php

namespace Eightfold\Shoop\Tests\Search;

use PHPUnit\Framework\TestCase;



use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    ESBoolean,
    ESDictionary,
    ESInt,
    ESJson,
    ESObject,
    ESString
};
/**
 * The `has()` method ehcks to see if the given value exists for any member of the `Shoop type`.
 *
 * @return Eightfold\Shoop\ESBoolean
 */
class HasTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->has("world");
        $this->assertTrue($actual->unfold());

        $expected = "h";
        $actual = ESArray::fold($base)->has("hello", function($result, $value) {
            if ($result->unfold()) {
                return "h";
            }
            return null;
        });
        $this->assertSame($expected, $actual->unfold());

        $expected = "h";
        $actual = ESArray::fold($base)->doesNothave(
            "hi", function($result, $value) {
                if ($result->unfold()) {
                    return null;
                }
                return "h";
        });
        $this->assertSame($expected, $actual->unfold());

        $actual = ESArray::fold($base)->hasMember(0);
        $this->assertTrue($actual->unfold());
    }

    /**
     * @not
     */
    public function testESBoolean()
    {
        $this->assertFalse(false);
    }

    public function testESDictionary()
    {
        $base = ["member" => "value"];
        $actual = ESDictionary::fold($base)->has("value");
        $this->assertTrue($actual->unfold());

        $expected = "v";
        $actual = ESDictionary::fold($base)->has(
            "value", function($result, $value) {
                if ($result->unfold()) {
                    return "v";
                }
                return null;
        });
        $this->assertSame($expected, $actual->unfold());

        $expected = "v";
        $actual = ESDictionary::fold($base)->doesNothave(
            "hi", function($result, $value) {
                if ($result->unfold()) {
                    return null;
                }
                return "v";
        });
        $this->assertSame($expected, $actual->unfold());

        $actual = ESDictionary::fold($base)->hasMember("member");
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

        $expected = "v";
        $actual = ESJson::fold($base)->has("value3", function($result, $value) {
            if ($result->unfold()) {
                return "v";
            }
            return null;
        });
        $this->assertSame($expected, $actual->unfold());

        $expected = "v";
        $actual = ESJson::fold($base)->doesNothave(
            "hi", function($result, $value) {
                if ($result->unfold()) {
                    return null;
                }
                return "v";
        });
        $this->assertSame($expected, $actual->unfold());

        $actual = ESJson::fold($base)->hasMember("member2");
        $this->assertTrue($actual->unfold());

        $base = '{"events":{"2020":{"5":{"20":[{"title": "Event at Meetup"}]}}}}';
        $actual = ESJson::fold($base)->getEvents()->hasMember("2020");
        $this->assertTrue($actual->unfold());
    }

    /**
     * Packagist doesn't seem to be updating
     */
    public function testESObject()
    {
        $base = new \stdClass();
        $base->testMember = "test";

        $actual = ESObject::fold($base)->has("test");
        $this->assertTrue($actual->unfold());

        $expected = "t";
        $actual = ESObject::fold($base)->has("test", function($result, $value) {
            if ($result->unfold()) {
                return "t";
            }
            return null;
        });
        $this->assertSame($expected, $actual->unfold());

        $expected = "t";
        $actual = ESObject::fold($base)->doesNothave(
            "hi", function($result, $value) {
                if ($result->unfold()) {
                    return null;
                }
                return "t";
        });
        $this->assertSame($expected, $actual->unfold());

        $actual = ESObject::fold($base)->hasMember("testMember");
        $this->assertTrue($actual->unfold());
    }

    public function testESString()
    {
        $actual = ESString::fold("a")->has("b");
        $this->assertFalse($actual->unfold());

        $actual = ESString::fold("b")->has("b");
        $this->assertTrue($actual->unfold());

        $base = "test";
        $expected = "t";
        $actual = ESString::fold($base)->has("t", function($result, $value) {
            if ($result->unfold()) {
                return "t";
            }
            return null;
        });
        $this->assertSame($expected, $actual->unfold());

        $expected = "t";
        $actual = ESString::fold($base)->doesNothave(
            "d", function($result, $value) {
                if ($result->unfold()) {
                    return null;
                }
                return "t";
        });
        $this->assertSame($expected, $actual->unfold());
    }
}
