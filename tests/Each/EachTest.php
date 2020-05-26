<?php

namespace Eightfold\Shoop\Tests\Drop;

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
 * The `each()` method iterates over each element of the array representation of the `Shoop type` and passes the value-member pair to the specified closure.
 *
 * @return Eightfold\Shoop\ESArray
 */
class EachTest extends TestCase
{
    public function testESArray()
    {
        $expected = 10;
        $actual = 0;
        Shoop::array([0, 2, 3, 5])->each(function($value) use (&$actual) {
            $actual += $value;
        });
        $this->assertEquals($expected, $actual);
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
        $expected = [1, 2];
        $actual = Shoop::dictionary(["one" => 1, "two" => 2])->each(function($value) {
            return $value;
        });
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESInt()
    {
        $expected = 6;
        $actual = 0;
        Shoop::int(3)->each(function($value) use (&$actual) {
            $actual += $value;
        });
        $this->assertEquals($expected, $actual);
    }

    public function testESJson()
    {
        $json = '{"one":1,"two":2}';

        $membersExpected = ["one", "two"];
        $valuesExpected = [1, 2];
        $members = [];
        $values = [];
        Shoop::json($json)->each(function($value, $member) use (&$members, &$values) {
            $members[] = $member;
            $values[] = $value;
        });
        $this->assertEquals($membersExpected, $members);
        $this->assertEquals($valuesExpected, $values);
    }

    public function testESObject()
    {
        $object = new \stdClass();
        $object->one = 1;
        $object->two = 2;

        $membersExpected = ["one", "two"];
        $valuesExpected = [1, 2];
        $members = [];
        $values = [];
        Shoop::object($object)->each(function($value, $member) use (&$members, &$values) {
            $members[] = $member;
            $values[] = $value;
        });
        $this->assertEquals($membersExpected, $members);
        $this->assertEquals($valuesExpected, $values);
    }

    public function testESString()
    {
        $string = "uppercase";

        $expected = "UPPERCASE";
        $actual = Shoop::string($string)->each(function($value) {
            return strtoupper($value);
        })->join("");
        $this->assertEquals($expected, $actual);
    }
}
