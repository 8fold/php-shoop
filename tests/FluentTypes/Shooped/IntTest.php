<?php

namespace Eightfold\Shoop\Tests\Shooped;

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
 * The `int()` method converts the Shoop type to the `PHP integer` equivalent.
 *
 * @return Eightfold\Shoop\ESInt
 */
class IntTest extends TestCase
{
    /**
     * @see PhpTypeJuggle::indexedArrayToInt
     */
    public function testESArray()
    {
        $expected = 1;

        $actual = ESArray::fold(['testing'])->int();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpTypeJuggle::boolToInt
     */
    public function testESBoolean()
    {
        $expected = 1;

        $actual = ESBoolean::fold(true)->int();
        $this->assertEquals($expected, $actual->unfold());

        $expected = 0;

        $actual = ESBoolean::fold(false)->int();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpTypeJuggle::associativeArrayToInt
     */
    public function testESDictionary()
    {
        $expected = 0;

        $actual = ESDictionary::fold([])->int();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESInt The same value.
     */
    public function testESInt()
    {
        $expected = 1;

        $actual = ESInt::fold(1)->int();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpTypeJuggle::jsonToInt
     */
    public function testESJson()
    {
        $expected = 1;

        $actual = ESJson::fold('{"test":"test"}')->int();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpTypeJuggle::objectToInt
     */
    public function testESObject()
    {
        $expected = 0;

        $actual = ESObject::fold(new \stdClass())->int();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpTypeJuggle::stringToInt
     */
    public function testESString()
    {
        $expected = 0;

        $actual = ESString::fold("0")->int();
        $this->assertEquals($expected, $actual->unfold());

        $expected = 0;

        $actual = ESString::fold("hello")->int();
        $this->assertEquals($expected, $actual->unfold());
    }
}
