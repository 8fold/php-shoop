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
 * @group  BooleanFluent
 *
 * The `boolean()` method converts the Shoop type to an `ESBoolean` type.
 *
 * @return Eightfold\Shoop\ESBoolean
 */
class BoolTest extends TestCase
{
    /**
     * @see PhpIndexedArray::toBool
     */
    public function testESArray()
    {
        $actual = ESArray::fold(['testing'])->boolean();
        $this->assertTrue($actual->unfold());

        $actual = ESArray::fold([])->boolean();
        $this->assertFalse($actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESBoolean The same value.
     */
    public function testESBoolean()
    {
        $actual = ESBoolean::fold(true)->boolean();
        $this->assertTrue($actual->unfold());

        $actual = ESBoolean::fold(false)->boolean();
        $this->assertFalse($actual->unfold());
    }

    /**
     * @see PhpAssociativeArray::toBool
     */
    public function testESDictionary()
    {
        $actual = ESDictionary::fold([])->boolean();
        $this->assertFalse($actual->unfold());
    }

    /**
     * @see Phpint::toBool
     */
    public function testESInteger()
    {
        $actual = ESInteger::fold(1)->boolean();
        $this->assertTrue($actual->unfold());

        $actual = ESInteger::fold(0)->boolean();
        $this->assertFalse($actual->unfold());
    }

    /**
     * @see PhpJson::toBool
     */
    public function testESJson()
    {
        $actual = ESJson::fold('{"test":"test"}')->boolean();
        $this->assertTrue($actual->unfold());

        $actual = ESJson::fold('{}')->boolean();
        $this->assertFalse($actual->unfold());
    }

    /**
     * @see PhpObject::toBool
     */
    public function testESObject()
    {
        $object = new \stdClass();

        $actual = ESObject::fold($object)->boolean();
        $this->assertFalse($actual->unfold());

        $object->name = "hello";
        $actual = ESObject::fold($object)->boolean();
        $this->assertTrue($actual->unfold());
    }

    /**
     * @see PhpString::toBool
     */
    public function testESString()
    {
        $actual = ESString::fold("")->boolean();
        $this->assertFalse($actual->unfold());

        $actual = ESString::fold("hello")->boolean();
        $this->assertTrue($actual->unfold());
    }
}
