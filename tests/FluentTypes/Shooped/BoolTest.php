<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;



use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    ESBool,
    ESDictionary,
    ESInt,
    ESJson,
    ESObject,
    ESString
};

/**
 * The `bool()` method converts the Shoop type to an `ESBool` type.
 *
 * @return Eightfold\Shoop\ESBool
 */
class BoolTest extends TestCase
{
    /**
     * @see PhpIndexedArray::toBool
     */
    public function testESArray()
    {
        $actual = ESArray::fold(['testing'])->bool();
        $this->assertTrue($actual->unfold());

        $actual = ESArray::fold([])->bool();
        $this->assertFalse($actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESBool The same value.
     */
    public function testESBool()
    {
        $actual = ESBool::fold(true)->bool();
        $this->assertTrue($actual->unfold());

        $actual = ESBool::fold(false)->bool();
        $this->assertFalse($actual->unfold());
    }

    /**
     * @see PhpAssociativeArray::toBool
     */
    public function testESDictionary()
    {
        $actual = ESDictionary::fold([])->bool();
        $this->assertFalse($actual->unfold());
    }

    /**
     * @see Phpint::toBool
     */
    public function testESInt()
    {
        $actual = ESInt::fold(1)->bool();
        $this->assertTrue($actual->unfold());

        $actual = ESInt::fold(0)->bool();
        $this->assertFalse($actual->unfold());
    }

    /**
     * @see PhpJson::toBool
     */
    public function testESJson()
    {
        $actual = ESJson::fold('{"test":"test"}')->bool();
        $this->assertTrue($actual->unfold());

        $actual = ESJson::fold('{}')->bool();
        $this->assertFalse($actual->unfold());
    }

    /**
     * @see PhpObject::toBool
     */
    public function testESObject()
    {
        $object = new \stdClass();

        $actual = ESObject::fold($object)->bool();
        $this->assertFalse($actual->unfold());

        $object->name = "hello";
        $actual = ESObject::fold($object)->bool();
        $this->assertTrue($actual->unfold());
    }

    /**
     * @see PhpString::toBool
     */
    public function testESString()
    {
        $actual = ESString::fold("")->bool();
        $this->assertFalse($actual->unfold());

        $actual = ESString::fold("hello")->bool();
        $this->assertTrue($actual->unfold());
    }
}
