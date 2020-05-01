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
 * The `bool()` method converts the 8fold type to an `ESBool` type.
 *
 * Typically this means using PHP to cast the value after calling `unfold()`
 *
 * @declared Eightfold\Shoop\Interfaces\Shooped
 *
 * @defined Eightfold\Shoop\Traits\ShoopedImp
 *
 * @overridden Eightfold\Shoop\ESObject
 *
 * @return Eightfold\Shoop\ESBool
 */
class ToBoolTest extends TestCase
{
    public function testESArray()
    {
        $actual = ESArray::fold(['testing'])->bool();
        $this->assertTrue($actual->unfold());

        $actual = ESArray::fold([])->bool();
        $this->assertFalse($actual->unfold());
    }

    public function testESBool()
    {
        $actual = ESBool::fold(true)->bool();
        $this->assertTrue($actual->unfold());

        $actual = ESBool::fold(false)->bool();
        $this->assertFalse($actual->unfold());
    }

    public function testESDictionary()
    {
        $actual = ESDictionary::fold([])->bool();
        $this->assertFalse($actual->unfold());
    }

    public function testESInt()
    {
        $actual = ESInt::fold(1)->bool();
        $this->assertTrue($actual->unfold());

        $actual = ESInt::fold(0)->bool();
        $this->assertFalse($actual->unfold());
    }

    /**
     * Converts to an array before checking if empty.
     *
     * @see Eightfold\Shoop\Test\ToArray
     */
    public function testESJson()
    {
        $actual = ESJson::fold('{"test":"test"}')->bool();
        $this->assertTrue($actual->unfold());

        $actual = ESJson::fold('{}')->bool();
        $this->assertFalse($actual->unfold());
    }

    /**
     * Converts to an array before checking if empty.
     *
     * @see Eightfold\Shoop\Test\ToArray
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

    public function testESString()
    {
        $actual = ESString::fold("")->bool();
        $this->assertFalse($actual->unfold());

        $actual = ESString::fold("hello")->bool();
        $this->assertTrue($actual->unfold());
    }
}
