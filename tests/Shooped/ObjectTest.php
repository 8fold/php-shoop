<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    Type,
    ESArray,
    ESBool,
    ESDictionary,
    ESInt,
    ESJson,
    ESObject,
    ESString
};

/**
 * The `object()` method converts the `Shoop type` to the `PHP object` equivalent.
 *
 * @return Eightfold\Shoop\ESObject
 */
class ObjectTest extends TestCase
{
    /**
     * @see PhpTypeJuggle::indexedArrayToObject
     */
    public function testESArray()
    {
        $expected = new \stdClass();
        $expected->i0 = "testing";

        $actual = ESArray::fold(['testing'])->object();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpTypeJuggle::boolToObject
     */
    public function testESBool()
    {
        $expected = new \stdClass();
        $expected->true = true;
        $expected->false = false;

        $actual = ESBool::fold(true)->object();
        $this->assertEquals($expected, $actual->unfold());

        $expected = new \stdClass();
        $expected->true = false;
        $expected->false = true;

        $actual = ESBool::fold(false)->object();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpTypeJuggle::associativeArrayToObject
     */
    public function testESDictionary()
    {
        $expected = new \stdClass();

        $actual = ESDictionary::fold([])->object();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpTypeJuggle::intToObject
     */
    public function testESInt()
    {
        $expected = new \stdClass();
        $expected->i0 = 0;
        $expected->i1 = 1;

        $actual = ESInt::fold(1)->object();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpTypeJuggle::jsonToObject
     */
    public function testESJson()
    {
        $expected = new \stdClass();
        $expected->test = "test";

        $actual = ESJson::fold('{"test":"test"}')->object();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESObject The same value.
     */
    public function testESObject()
    {
        $expected = new \stdClass();

        $actual = ESObject::fold(new \stdClass())->object();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpTypeJuggle::stringToObject
     */
    public function testESString()
    {
        $expected = new \stdClass();
        $expected->string = "";

        $actual = ESString::fold("")->object();
        $this->assertEquals($expected, $actual->unfold());
    }
}
