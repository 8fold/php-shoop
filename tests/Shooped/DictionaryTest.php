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
    ESString,
    ESYaml
};
/**
 * The `dictionary()` method converts the original value to the `PHP associative array` equivalent.
 *
 * @return Eightfold\Shoop\ESDictionary
 */
class DictionaryTest extends TestCase
{
    /**
     * @see PhpIndexedArray::toAssociativeArray
     */
    public function testESArray()
    {
        $expected = ["i0" => "hi"];

        $actual = ESArray::fold([0 => "hi"])->dictionary();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpBool::toAssociativeArray
     */
    public function testESBool()
    {
        $expected = ["true" => true, "false" => false];

        $actual = ESBool::fold(true)->dictionary();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESDictionary The same value.
     */
    public function testESDictionary()
    {
        $expected = ["hello" => "world"];

        $actual = ESDictionary::fold($expected)->dictionary();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpInt::toAssociativeArray
     */
    public function testESInt()
    {
        $expected = ["i0" => 0, "i1" => 1, "i2" => 2, "i3" => 3, "i4" => 4, "i5" => 5];

        $actual = ESInt::fold(5)->dictionary();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpJson::toAssociativeArray
     */
    public function testESJson()
    {
        $expected = ["test" => true];

        $actual = ESJson::fold('{"test":true}')->dictionary();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpObeject::toAssociativeArray
     */
    public function testESObject()
    {
        $expected = ["test" => true];

        $object = new \stdClass();
        $object->test = true;

        $actual = ESObject::fold($object)->dictionary();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpString::toAssociativeArray
     */
    public function testESString()
    {
        $expected = ["i0" => "h", "i1" => "e", "i2" => "l", "i3" => "l", "i4" => "o"];

        $actual = ESString::fold("hello")->dictionary();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see SymfonyYaml::toAssociativeArray
     */
    public function testESYaml()
    {
        $expected = ["test" => true];

        $actual = ESYaml::fold("test: true")->dictionary();
        $this->assertEquals($expected, $actual->unfold());
    }
}
