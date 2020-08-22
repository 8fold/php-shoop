<?php

namespace Eightfold\Shoop\Tests\Search;

use PHPUnit\Framework\TestCase;



use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    ESBoolean,
    ESDictionary,
    ESInteger,
    ESJson,
    ESTuple,
    ESString
};
/**
 * The `isIn()` checks if the given `Shoop type` `has()` the value of the original `Shoop type`.
 *
 * @return Eightfold\Shoop\ESBoolean
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

    public function testESBoolean()
    {
        $base = true;
        $container = [false, false, false];
        $actual = ESBoolean::fold($base)->isIn($container);
        $this->assertFalse($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = ["member" => "value"];
        $container = ["dict" => $base];
        $actual = ESDictionary::fold($base)->isIn($container);
        $this->assertTrue($actual->unfold());
    }

    public function testESInteger()
    {
        $base = 1;
        $container = [0, 3, 2];
        $actual = Shoop::integer($base)->isIn($container);
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

    public function testESTuple()
    {
        $base = new \stdClass();
        $base->testMember = "test";
        $container = ["object" => $base];
        // TODO: Should also be able to put this in JSON: {"testMember":"test"}
        //      and have it be true.

        $actual = ESTuple::fold($base)->isIn($container);
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
