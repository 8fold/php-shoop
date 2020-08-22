<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESBoolean;
use Eightfold\Shoop\FluentTypes\ESDictionary;
use Eightfold\Shoop\FluentTypes\ESInteger;
use Eightfold\Shoop\FluentTypes\ESJson;
use Eightfold\Shoop\FluentTypes\ESTuple;
use Eightfold\Shoop\FluentTypes\ESString;

/**
 * The `object()` method converts the Shoop type to a `PHP object` equivalent.
 *
 * @return Eightfold\Shoop\ESTuple
 */
class ObjectTest extends TestCase
{
    /**
     * @see PhpIndexedArray::toObject
     */
    public function testESArray()
    {
        $expected = new \stdClass();
        $expected->i0 = "testing";

        $actual = ESArray::fold(['testing'])->object();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpBool::toObject
     */
    public function testESBoolean()
    {
        $expected = new \stdClass();
        $expected->true = true;
        $expected->false = false;

        $actual = ESBoolean::fold(true)->object();
        $this->assertEquals($expected, $actual->unfold());

        $expected = new \stdClass();
        $expected->true = false;
        $expected->false = true;

        $actual = ESBoolean::fold(false)->object();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpAssociativeArray::toObject
     */
    public function testESDictionary()
    {
        $expected = new \stdClass();

        $actual = ESDictionary::fold([])->object();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpInt::toObject
     */
    public function testESInteger()
    {
        $expected = new \stdClass();
        $expected->i0 = 0;
        $expected->i1 = 1;

        $actual = ESInteger::fold(1)->object();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpJson::toObject
     */
    public function testESJson()
    {
        $expected = new \stdClass();
        $expected->test = "test";

        $actual = ESJson::fold('{"test":"test"}')->object();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESTuple The same value.
     */
    public function testESTuple()
    {
        $expected = new \stdClass();

        $actual = ESTuple::fold(new \stdClass())->object();
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @see PhpString::toObject
     */
    public function testESString()
    {
        $expected = new \stdClass();
        $expected->string = "";

        $actual = ESString::fold("")->object();
        $this->assertEquals($expected, $actual->unfold());
    }
}
