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
 * The `last()` method returns the last value from an array, dicitonary-like, and string object.
 *
 * @return multiple If the value is a `PHP type`, it will be converted to the equivalent `Shoop type`. If the value coforms to the `Shooped interface`, the instance is returned. Otherwise, the raw value is returned (instances of `non-Shoop types or class`, for example.
 */
class LastTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];

        $expected = "world";
        $actual = Shoop::array($base)->last();
        $this->assertEquals(ESString::class, get_class($actual));
        $this->assertEquals($expected, $actual);

        $expected = ["hello", "world"];
        $actual = Shoop::array($base)->last(2);
        $this->assertEquals($expected, $actual->unfold());

        $expected = 1;
        $actual = Shoop::array([1])->last();
        $this->assertEquals($expected, $actual->unfold());

        $expected = "";
        $actual = Shoop::array([])->last();
        $this->assertEquals($expected, $actual->unfold());

        $expected = "";
        $actual = Shoop::array([])->first();
        $this->assertEquals($expected, $actual->unfold());
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
        $base = ["first" => 1, "second" => 2];

        $expected = 2;
        $actual = ESDictionary::fold($base)->last();
        $this->assertEquals(ESInteger::class, get_class($actual));
        $this->assertEquals($expected, $actual->unfold());

        $base = ["first" => 1, "second" => 2, "third" => 3];
        $expected = [2, 3];
        $actual = ESDictionary::fold($base)->last(2);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @not
     */
    public function testESInteger()
    {
        $this->assertFalse(false);
    }

    public function testESJson()
    {
        $base = '{"member":"value", "member2":"value2", "member3":"value3"}';

        $expected = "value3";
        $actual = ESJson::fold($base)->last();
        $this->assertEquals(ESString::class, get_class($actual));
        $this->assertEquals($expected, $actual);

        $expected = ["value2", "value3"];
        $actual = ESJson::fold($base)->last(2);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESTuple()
    {
        $base = new \stdClass();
        $base->testMember = new \stdClass();
        $base->testMember2 = 2;

        $expected = 2;
        $actual = ESTuple::fold($base)->last();
        $this->assertEquals(ESInteger::class, get_class($actual));
        $this->assertEquals($expected, $actual->unfold());

        $expected = [new \stdClass(), 2];
        $actual = ESTuple::fold($base)->last(2);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testESString()
    {
        $expected = "!";
        $actual = Shoop::string("Hello, World!")->last();
        $this->assertEquals(ESString::class, get_class($actual));
        $this->assertEquals($expected, $actual);

        $expected = "World!";
        $actual = Shoop::string("Hello, World!")->last(6);
        $this->assertEquals($expected, $actual);
    }
}
