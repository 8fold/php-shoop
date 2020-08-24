<?php

namespace Eightfold\Shoop\Tests\Shooped;

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
 * @group TypeAsFluent
 * @group TupleFluent
 *
 * The `tuple()` method converts the Shoop type to a `PHP object` equivalent.
 *
 * @return Eightfold\Shoop\ESTuple
 */
class TupleTest extends TestCase
{
    /**
     * @test
     */
    public function ESArray()
    {
        AssertEqualsFluent::applyWith((object) ["i0" => "testing"], 5.08)
            ->unfoldUsing(ESArray::fold(["testing"])->asTuple());
    }

    /**
     * @test
     */
    public function ESBoolean()
    {
        AssertEqualsFluent::applyWith(
            (object) ["false" => false, "true" => true], 4.14
        )->unfoldUsing(ESBoolean::fold(true)->asTuple());

        AssertEqualsFluent::applyWith(
            (object) ["false" => true, "true" => false]
        )->unfoldUsing(ESBoolean::fold(false)->asTuple());
    }

    /**
     * @test
     */
    public function ESDictionary()
    {
        AssertEqualsFluent::applyWith(new stdClass, 4.03)
            ->unfoldUsing(ESDictionary::fold([])->asTuple());
    }

    /**
     * @test
     */
    public function ESInteger()
    {
        AssertEqualsFluent::applyWith((object) ["i0" => 0, "i1" => 1], 3.86)
            ->unfoldUsing(ESInteger::fold(1)->asTuple());
    }

    /**
     * @test
     */
    public function ESJson()
    {
        AssertEqualsFluent::applyWith((object) ["test" => "test"], 4.18)
            ->unfoldUsing(ESJson::fold('{"test":"test"}')->asTuple());
    }

    /**
     * @test
     */
    public function ESTuple()
    {
        AssertEqualsFluent::applyWith(new stdClass, 3.18)
            ->unfoldUsing(ESTuple::fold(new stdClass)->asTuple());
    }

    /**
     * @test
     */
    public function ESString()
    {
        AssertEqualsFluent::applyWith((object) ["content" => ""], 6.36)
            ->unfoldUsing(ESString::fold("")->asTuple());
    }
}
