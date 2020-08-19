<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESBoolean;
use Eightfold\Shoop\FluentTypes\ESDictionary;
use Eightfold\Shoop\FluentTypes\ESInteger;
use Eightfold\Shoop\FluentTypes\ESJson;
use Eightfold\Shoop\FluentTypes\ESObject;
use Eightfold\Shoop\FluentTypes\ESString;

/**
 * @group ArrayFluent
 *
 * The `array()` method typically converts the `Shoop type` to a `PHP indexed array` equivalent.
 *
 * @return Eightfold\Shoop\ESArray
 */
class ArrayTest extends TestCase
{
    /**
     * @return Eightfold\Shoop\ESArray The original value.
     */
    public function testESArray()
    {
        $expected = [];

        $actual = ESArray::fold([])->array();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpBool::toIndexedArray
     */
    public function testESBoolean()
    {
        $expected = [true];

        $actual = ESBoolean::fold(true)->array();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpAssociativeArray::toIndexedArray
     */
    public function testESDictionary()
    {
        $expected = [];

        $actual = ESDictionary::fold([])->array();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpInt::toIndexedArray
     */
    public function testESInteger()
    {
        $expected = [0, 1, 2, 3, 4, 5];

        $actual = ESInteger::fold(5)->array();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpJson::toIndexedArray
     */
    public function testESJson()
    {
        $expected = ["test"];

        $actual = ESJson::fold('{"test":"test"}')->array();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpObject::toIndexedArray
     */
    public function testESObject()
    {
        $expected = [];

        $actual = ESObject::fold(new \stdClass())->array();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpString::toIndexedArray
     */
    public function testESString()
    {
        $expected = ["h", "e", "l", "l", "o"];

        $actual = ESString::fold("hello")->array();
        $this->assertEquals($expected, $actual->unfold());
    }
}
