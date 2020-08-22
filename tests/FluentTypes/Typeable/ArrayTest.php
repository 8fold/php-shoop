<?php

namespace Eightfold\Shoop\Tests\Typeable;

use PHPUnit\Framework\TestCase;
use Eightfold\Shoop\Tests\AssertEqualsFluent;

use \stdClass;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESBoolean;
use Eightfold\Shoop\FluentTypes\ESDictionary;
use Eightfold\Shoop\FluentTypes\ESInteger;
use Eightfold\Shoop\FluentTypes\ESJson;
use Eightfold\Shoop\FluentTypes\ESTuple;
use Eightfold\Shoop\FluentTypes\ESString;

/**
 * @group Typeable
 * @group ArrayFluent
 *
 * The `array()` method typically converts the `Shoop type` to a `PHP indexed array` equivalent.
 *
 * @return Eightfold\Shoop\ESArray
 */
class ArrayTest extends TestCase
{
    /**
     * @test
     */
    public function ESArray()
    {
        AssertEqualsFluent::applyWith([], 1.46)
            ->unfoldUsing(ESArray::fold([])->array());
    }

    /**
     * @test
     */
    public function ESBoolean()
    {
        AssertEqualsFluent::applyWith([false, true], 1.68)
            ->unfoldUsing(ESBoolean::fold(true)->array());
    }

    /**
     * @test
     */
    public function ESDictionary()
    {
        AssertEqualsFluent::applyWith(["string", true], 1.37)
            ->unfoldUsing(
                ESDictionary::fold(["a" => "string", "b" => true])->array()
            );
    }

    /**
     * @test
     */
    public function ESInteger()
    {
        AssertEqualsFluent::applyWith([0, 1, 2, 3, 4, 5], 1.55)
            ->unfoldUsing(ESInteger::fold(5)->array());
    }

    /**
     * @test
     */
    public function ESJson()
    {
        AssertEqualsFluent::applyWith(["test"], 2.22)
            ->unfoldUsing(ESJson::fold('{"test":"test"}')->array());
    }

    /**
     * @test
     */
    public function ESTuple()
    {
        AssertEqualsFluent::applyWith([], 8.49)
            ->unfoldUsing(ESTuple::fold(new stdClass)->array());
    }

    /**
     * @test
     */
    public function testESString()
    {
        AssertEqualsFluent::applyWith(["h", "e", "l", "l", "o"], 2.32)
            ->unfoldUsing(ESString::fold("hello")->array());
    }
}
