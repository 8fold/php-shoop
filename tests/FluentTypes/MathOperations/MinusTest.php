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
 * The `minus()` method for most `Shoop types` unsets or removes the specified members.
 */
class MinusTest extends TestCase
{
    /**
     * @return Eightfold\Shoop\ESArray With the specified indeces and corresponding values removed and re-indexed.
     */
    public function ESArray()
    {
        $expected = ["goodbye"];
        $actual = ESArray::fold(["hello", "goodbye", "hello"])->minus(0, 2);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @not
     */
    public function ESBoolean()
    {
        $this->assertFalse(false);
    }

    /**
     * @return Eightfold\Shoop\ESDictionary With the specified members and corresponding values removed.
     */
    public function ESDictionary()
    {
        $expected = [];
        $actual = ESDictionary::fold(["member" => "value", "member2" => "value2"])->minus("member", "member2");
        $this->assertEquals($expected, $actual->unfold());
    }

    public function ESInteger()
    {
        $expected = 2;
        $actual = ESInteger::fold(5)->minus(3);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see ESTuple->minus()
     */
    public function ESJson()
    {
        $expected = '{"member":"value"}';
        $actual = ESJson::fold('{"member":"value","member2":"value2"}')->minus("member2");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESTuple With the specified members and corresponding values removed.
     */
    public function ESTuple()
    {
        $expected = new \stdClass();
        $expected->member = "value";

        $actual = new \stdClass();
        $actual->member = "value";
        $actual->member2 = "value2";
        $actual = ESTuple::fold($actual)->minus("member2");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\FluentTypes\ESString With the specified letters removed.
     */
    public function ESString()
    {
        $expected = "He, rd";
        $actual = ESString::fold("Hello, World!")->minus("W", "l", "o", "!");
        $this->assertEquals($expected, $actual->unfold());
    }
}
