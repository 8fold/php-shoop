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
class HasMemberTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base);
        $actual = $actual->hasMember(1);
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
        $actual = ESJson::fold($base)->hasMember("member2");
        $this->assertTrue($actual->unfold());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->testMember = "test";

        $actual = ESObject::fold($base)->hasMember("testMember");
        $this->assertTrue($actual->unfold());
    }

    public function testESString()
    {
        $base = "Hello, World!";

        $actual = ESString::fold($base)->hasMember(13);
        $this->assertFalse($actual->unfold());
    }
}
