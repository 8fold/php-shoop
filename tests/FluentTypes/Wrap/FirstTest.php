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
 * The `first()` method returns the first value from an array, dicitonary-like, and string object.
 *
 * @return multiple If the value is a `PHP type`, it will be converted to the equivalent `Shoop type`. If the value coforms to the `Shooped interface`, the instance is returned. Otherwise, the raw value is returned (instances of `non-Shoop types or class`, for example.
 */
class FirstTest extends TestCase
{
    public function ESArray()
    {
        $base = ["hello", "world"];

        $expected = "hello";
        $actual = Shoop::array($base)->first();
        $this->assertEquals(ESString::class, get_class($actual));
        $this->assertEquals($expected, $actual);

        $expected = ["hello", "world"];
        $actual = Shoop::array($base)->first(2);
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
        $base = ["first" => 1, "second" => "value"];

        $expected = 1;
        $actual = ESDictionary::fold($base)->first();
        $this->assertEquals(ESInteger::class, get_class($actual));
        $this->assertEquals($expected, $actual->unfold());

        $expected = [1, "value"];
        $actual = ESDictionary::fold($base)->first(2);
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
        $base = '{"member":"value", "member2":"value2", "member3":"value3"}';

        $expected = "value";
        $actual = ESJson::fold($base)->first();
        $this->assertEquals(ESString::class, get_class($actual));
        $this->assertEquals($expected, $actual);

        $expected = ["value", "value2", "value3"];
        $actual = ESJson::fold($base)->first(3);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function ESTuple()
    {
        $base = new \stdClass();
        $base->testMember = new \stdClass();

        $expected = new \stdClass();
        $actual = ESTuple::fold($base)->first();
        $this->assertEquals(ESTuple::class, get_class($actual));
        $this->assertEquals($expected, $actual->unfold());
    }

    public function ESString()
    {
        $expected = "H";
        $actual = Shoop::string("Hello, World!")->first();
        $this->assertEquals(ESString::class, get_class($actual));
        $this->assertEquals($expected, $actual);

        $expected = "Hello";
        $actual = Shoop::string("Hello, World!")->first(5);
        $this->assertEquals($expected, $actual->unfold());
    }
}
