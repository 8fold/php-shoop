<?php

namespace Eightfold\Shoop\Tests\MathOperations;

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
 * There is no common or general implementation for the `divide()` method across `Shoop types`.
 */
class DivideTest extends TestCase
{
    /**
     * @return Eightfold\Shoop\ESArry There are two ideces. The first represents everything prior to the index to divide on; the second is everything after.
     */
    public function ESArray()
    {
        $expected = [
            ["hello"],
            ["goodbye", "hello"]
        ];
        $actual = ESArray::fold(["hello", "goodbye", "hello"])->divide(1);
        $this->assertEquals($expected, $actual->unfold());

        $actual = ESArray::fold(["hello", "", null, "goodbye", "", "hello"])
            ->divide(2, false);
        $this->assertSame($expected, $actual->unfold());
    }

    /**
     * @not
     */
    public function ESBoolean()
    {
        $this->assertFalse(false);
    }

    /**
     * @return Eightfold\Shoop\ESDictionary There are two members "members" and "values". The "members" holds a `PHP indexed array` of all members from the original `PHP associative array`; the "values" member holds the values.
     */
    public function ESDictionary()
    {
        $expected = ["members" => ["member", "member2"], "values" => ["value", "value2"]];
        $actual = ESDictionary::fold(["member" => "value", "member2" => "value2"])->divide();
        $this->assertEquals($expected, $actual->unfold());

        $actual = ESDictionary::fold(["member" => "value", "" => null, "empty" => "", "member2" => "value2"])->divide(0, false);
        $this->assertSame($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESInteger The original value is mathematically divided by the given integer and rounded to nearest half to return a true ESInteger.
     */
    public function ESInteger()
    {
        $expected = 2;
        $actual = ESInteger::fold(5)->divide(3);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see ESTuple->divide()
     *
     * @return Eightfold\Shoop\ESJson
     */
    public function ESJson()
    {
        $expected = json_encode((object) ["members" => ["member", "member2"], "values" => ["value", "value2"]]);
        $actual = ESJson::fold('{"member":"value","member2":"value2"}')->divide();
        $this->assertEquals($expected, $actual->unfold());

        $actual = ESJson::fold('{"member":"value", "":null,"member2":"value2", "empty":""}')->divide(0, false);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see ESDictionary->divide()
     *
     * @return Eightfold\Shoop\ESTuple
     */
    public function ESTuple()
    {
        $expected = new \stdClass();
        $expected->members = ["member", "member2"];
        $expected->values = ["value", "value2"];

        $base = new \stdClass();
        $base->member = "value";
        $base->member2 = "value2";
        $actual = ESTuple::fold($base)->divide();
        $this->assertEquals($expected, $actual->unfold());

        $base->member3 = "";
        $actual = ESTuple::fold($base)->divide(0, false);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * Uses the `explode()` function from the PHP standard library to return an ESArray.
     *
     * @return Eightfold\Shoop\ESArray
     */
    public function ESStringEmpties()
    {
        $expected = ["Hello", "World!"];
        $actual = ESString::fold("Hello, World!")->divide(", ");
        $this->assertEquals($expected, $actual->unfold());

        $expected = ["class", "attribute value"];
        $actual = ESString::fold("class attribute value")->divide(" ", true, 2);
        $this->assertEquals($expected, $actual->unfold());

        list($attr, $value) = ESString::fold("class attribute value")->divide(" ", true, 2);
        $this->assertEquals("class", $attr);
        $this->assertEquals("attribute value", $value);

        $expected = [];
        $actual = ESString::fold("/")->divide("/", false);
        $this->assertEquals($expected, $actual->unfold());
    }
}
