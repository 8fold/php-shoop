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
 * The `hasMembers()` method checks if the given member exists in the `Shoop type`.
 *
 * @return Eightfold\Shoop\ESBoolean
 */
class HasMemberTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->hasMember(1);
        $this->assertTrue($actual->unfold());

        $actual = ESArray::fold($base)->hasMember(0, function($result, $value) {
            return $result;
        });
        $this->assertTrue($actual->unfold());

        $actual = ESArray::fold($base)->doesNotHaveMember(
            0, function($result, $value) {
            return $result;
        });
        $this->assertFalse($actual->unfold());
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
        $actual = ESDictionary::fold($base)->hasMember("member");
        $this->assertTrue($actual->unfold());

        $actual = ESDictionary::fold($base)->hasMember(
            "member", function($result, $value) {
            return $result;
        });
        $this->assertTrue($actual->unfold());

        $actual = ESDictionary::fold($base)->doesNotHaveMember(
            "array", function($result, $value) {
            return $result;
        });
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
        $actual = ESJson::fold($base)->hasMember("member2");
        $this->assertTrue($actual->unfold());

        $actual = ESJson::fold($base)->hasMember(
            "member", function($result, $value) {
            return $result;
        });
        $this->assertTrue($actual->unfold());

        $actual = ESJson::fold($base)->doesNotHaveMember(
            "member4", function($result, $value) {
            return $result;
        });
        $this->assertTrue($actual->unfold());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->testMember = "test";

        $actual = ESObject::fold($base)->hasMember("testMember");
        $this->assertTrue($actual->unfold());

        $actual = ESObject::fold($base)->hasMember(
            "testMember", function($result, $value) {
            return $result;
        });
        $this->assertTrue($actual->unfold());

        $actual = ESObject::fold($base)->doesNotHaveMember(
            "array", function($result, $value) {
            return $result;
        });
        $this->assertTrue($actual->unfold());
    }

    public function testESString()
    {
        $base = "Hello, World!";

        $actual = ESString::fold($base)->hasMember(13);
        $this->assertFalse($actual->unfold());

        $actual = ESString::fold($base)->hasMember(
            2, function($result, $value) {
            return $result;
        });
        $this->assertTrue($actual->unfold());

        $actual = ESString::fold($base)->doesNotHaveMember(
            20, function($result, $value) {
            return $result;
        });
        $this->assertTrue($actual->unfold());
    }
}
