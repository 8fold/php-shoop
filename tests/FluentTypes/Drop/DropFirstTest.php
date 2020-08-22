<?php

namespace Eightfold\Shoop\Tests\Drop;

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
 * The `dropFirst()` method removes *n* elements from the beginning of the given array.
 *
 * Note: You can specify the number of elements to remove.
 *
 * @return Eightfold\Shoop\ESArray
 */
class DropFirstTest extends TestCase
{
    public function ESArray()
    {
        $base = ["hello", "world"];

        $expected = [];
        $actual = Shoop::array($base)->dropFirst(2);
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
        $base = ["member" => "value", "member2" => "value2"];

        $expected = ["member2" => "value2"];
        $actual = ESDictionary::fold($base)->dropFirst();
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

        $expected = '{"member3":"value3"}';
        $actual = ESJson::fold($base)->dropFirst(2);
        $this->assertEquals($expected, $actual);
    }

    public function ESTuple()
    {
        $base = new \stdClass();
        $base->testMember = "test";

        $expected = new \stdClass();
        $actual = ESTuple::fold($base)->dropFirst();
        $this->assertEquals($expected, $actual->unfold());
    }

    public function ESString()
    {
        $base = "Hello, World!";

        $expected = "World!";
        $actual = ESString::fold($base)->dropFirst(7);
        $this->assertEquals($expected, $actual->unfold());

        $expected = "ello, World!";
        $actual = Shoop::string($base)->dropFirst();
        $this->assertEquals($expected, $actual->unfold());
    }
}
