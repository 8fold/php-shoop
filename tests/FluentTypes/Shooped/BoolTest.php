<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    ESBooleanean,
    ESDictionary,
    ESInt,
    ESJson,
    ESObject,
    ESString
};

/**
 * @group  BooleanFluent
 *
 * The `boolean()` method converts the Shoop type to an `ESBooleanean` type.
 *
 * @return Eightfold\Shoop\ESBooleanean
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
     * @return Eightfold\Shoop\ESBooleanean The same value.
     */
    public function testESBooleanean()
    {
        $actual = ESBooleanean::fold(true)->boolean();
        $this->assertTrue($actual->unfold());

        $actual = ESBooleanean::fold(false)->boolean();
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
    public function testESInt()
    {
        $actual = ESInt::fold(1)->boolean();
        $this->assertTrue($actual->unfold());

        $actual = ESInt::fold(0)->boolean();
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
