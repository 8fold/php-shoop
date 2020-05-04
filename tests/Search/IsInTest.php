<?php

namespace Eightfold\Shoop\Tests\Search;

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
 * The `isIn()` checks if the value of the current object is in another object.
 *
 * Only works with arrays and dictionaries at this point.
 *
 * @since 0.2.0
 *
 * @declared Eightfold\Shoop\Interfaces\Compare
 *
 * @defined Eightfold\Shoop\Traits\CompareImp
 *
 * @overridden
 *
 * @return Eightfold\Shoop\ESBool
 */
class IsInTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $container = [$base];

        $actual = ESArray::fold($base)->isIn($container);
        $this->assertTrue($actual->unfold());
    }

    public function testESBool()
    {
        $base = true;
        $container = [false, false, false];
        $actual = ESBool::fold($base)->isIn($container);
        $this->assertFalse($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = ["key" => "value"];
        $container = ["dict" => $base];
        $actual = ESDictionary::fold($base)->isIn($container);
        $this->assertTrue($actual->unfold());
    }

    public function testESInt()
    {
        $base = 1;
        $container = [0, 3, 2];
        $actual = Shoop::int($base)->isIn($container);
        $this->assertFalse($actual->unfold());
    }

    public function testESJson()
    {
        $base = '{"member":"value", "member2":"value2", "member3":"value3"}';
        // TODO: Need a way to use object as wrapper. Type::sanitizeType doesn't
        //      allow for specifying a destination type. Might be time to create
        //      generic logic for type juggling and casting. For this one, we'd
        //      want to be able to call something like objectToIndexedArray()
        //      base on the destination Shoop type being ESArray and the origin
        //      being an object.
        $container = [$base];

        $actual = ESJson::fold($base)->isIn($container);
        $this->assertTrue($actual->unfold());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->testMember = "test";
        $container = ["object" => $base];
        // TODO: Should also be able to put this in JSON: {"testMember":"test"}
        //      and have it be true.

        $actual = ESObject::fold($base)->isIn($container);
        $this->assertTrue($actual->unfold());
    }

    /**
     * Uses string instead of array.
     */
    public function testESString()
    {
        $base = "agile";
        $container = "fragile";
        $actual = ESString::fold($base)->isIn($container);
        $this->assertTrue($actual->unfold());

        $base = "file";
        $actual = ESString::fold($base)->isIn($container);
        $this->assertFalse($actual->unfold());
    }
}
