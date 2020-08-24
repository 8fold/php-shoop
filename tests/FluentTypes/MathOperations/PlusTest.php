<?php

namespace Eightfold\Shoop\Tests\Foldable;

use PHPUnit\Framework\TestCase;
use Eightfold\Shoop\Tests\AssertEqualsFluent;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESBoolean;
use Eightfold\Shoop\FluentTypes\ESDictionary;
use Eightfold\Shoop\FluentTypes\ESInteger;
use Eightfold\Shoop\FluentTypes\ESJson;
use Eightfold\Shoop\FluentTypes\ESTuple;
use Eightfold\Shoop\FluentTypes\ESString;

/**
 * The `set()` method in most cases sets the value for a specified members.
 */
class PlusTest extends TestCase
{
    /**
     * @return Eightfold\Shoop\ESArray After setting the value for the index.
     */
    public function ESArray()
    {
        $expected = ["hello", "world"];
        $actual = ESArray::fold(["hello", "Shoop"])->set("world", 1);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESBoolean Sets the value of the bool to the given bool.
     */
    public function ESBoolean()
    {
        $base = true;
        $actual = ESBoolean::fold($base)->set(false);
        $this->assertFalse($actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESDictionary After setting the value for the given member.
     */
    public function ESDictionary()
    {
        $base = ["member" => "value"];

        $expected = ["member" => "value", "member2" => "value2"];
        $actual = ESDictionary::fold($base)->set("value2", "member2");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESINt Sets the value of the integer to the given integer.
     */
    public function ESInteger()
    {
        $base = 10;

        $expected = 12;
        $actual = ESInteger::fold($base)->set(12);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESJson Sets the value of the member to the given value.
     */
    public function ESJson()
    {
        $base = '{}';

        $expected = '{"test":"test"}';
        $actual = ESJson::fold($base)->set("test", "test");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESTuple Sets the value of the member to the given value.
     */
    public function ESTuple()
    {
        $expected = new \stdClass();
        $expected->test = "test";
        $actual = ESTuple::fold(new \stdClass())->set("test", "test");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\FluentTypes\ESString Sets the value of the string to the given string.
     */
    public function ESString()
    {
        $base = "alphabet soup";

        $expected = "hello";
        $actual = ESString::fold($base)->set($expected);
        $this->assertEquals($expected, $actual->unfold());
    }
}
