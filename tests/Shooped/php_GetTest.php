<?php

namespace Eightfold\Shoop\Tests\Shooped;

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
 * `Shoop types` do not have accessible properties; however, attempting to get a property results in getting the unfolded (`PHP type`) value from the `Shoop type`.
 *
 * @return multiple Always a `PHP type`.
 */
class php_GetTest extends TestCase
{
    /**
     * @see PhpTypeJuggle::indexedArrayToAssociativeArray
     */
    public function testESArray()
    {
        $base = ESArray::fold([0 => "hi"]);

        $expected = ["i0" => "hi"];
        $actual = $base->dictionary;
        $this->assertEquals($expected, $actual);

        $expected = "hi";
        $actual = $base->i0;
        $this->assertEquals($expected, $actual);

        $actual = $base->first;
        $this->assertEquals($expected, $actual);

        $expected = [0 => "hi"];
        $actual = $base->plus; // requires arguments to modify value
        $this->assertEquals($expected, $actual);
    }

    public function testESBool()
    {
        $base = ESBool::fold(true);

        $expected = ["true" => true, "false" => false];
        $actual = $base->dictionary;
        $this->assertEquals($expected, $actual);

        $expected = true;
        $actual = $base->true;
        $this->assertTrue($expected, $actual);
    }

    public function testESDictionary()
    {
        $base = ESDictionary::fold(["hello" => "world"]);

        $expected = ["hello" => "world"];
        $actual = $base->dictionary;
        $this->assertEquals($expected, $actual);

        $expected = "world";
        $actual = $base->hello;
        $this->assertEquals($expected, $actual);
    }

    public function testESInt()
    {
        $base = ESInt::fold(5);

        $expected = ["i0" => 0, "i1" => 1, "i2" => 2, "i3" => 3, "i4" => 4, "i5" => 5];
        $actual = $base->dictionary;
        $this->assertEquals($expected, $actual);

        $expected = 5;
        $actual = $base->i5;
        $this->assertEquals($expected, $actual);
    }

    public function testESJson()
    {
        $base = ESJson::fold('{"test":true}');

        $expected = ["test" => true];
        $actual = $base->dictionary;
        $this->assertEquals($expected, $actual);

        $expected = true;
        $actual = $base->test;
        $this->assertEquals($expected, $actual);
    }

    public function testESObject()
    {
        $object = new \stdClass();
        $object->test = true;

        $base = ESObject::fold($object);

        $expected = ["test" => true];
        $actual = $base->dictionary;
        $this->assertEquals($expected, $actual);

        $expected = true;
        $actual = $base->test;
        $this->assertEquals($expected, $actual);
    }

    public function testESString()
    {
        $base = ESString::fold("hello");

        $expected = ["i0" => "h", "i1" => "e", "i2" => "l", "i3" => "l", "i4" => "o"];
        $actual = $base->dictionary;
        $this->assertEquals($expected, $actual);

        $expected = "l";
        $actual = $base->i2;
        $this->assertEquals($expected, $actual);
    }
}
