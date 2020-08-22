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
 * @group Typeable
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
            ->unfoldUsing(ESArray::fold(["testing"])->tuple());
    }

    /**
     * @test
     */
    public function ESBoolean()
    {
        AssertEqualsFluent::applyWith(
            (object) ["false" => false, "true" => true], 4.14
        )->unfoldUsing(ESBoolean::fold(true)->tuple());

        AssertEqualsFluent::applyWith(
            (object) ["false" => true, "true" => false]
        )->unfoldUsing(ESBoolean::fold(false)->tuple());
    }

    /**
     * @test
     */
    public function ESDictionary()
    {
        AssertEqualsFluent::applyWith(new stdClass, 4.03)
            ->unfoldUsing(ESDictionary::fold([])->tuple());
    }

    /**
     * @test
     */
    public function ESInteger()
    {
        AssertEqualsFluent::applyWith((object) ["i0" => 0, "i1" => 1], 3.86)
            ->unfoldUsing(ESInteger::fold(1)->tuple());
    }

    /**
     * @test
     */
    public function ESJson()
    {
        AssertEqualsFluent::applyWith((object) ["test" => "test"], 4.18)
            ->unfoldUsing(ESJson::fold('{"test":"test"}')->tuple());
    }

    /**
     * @test
     */
    public function ESTuple()
    {
        AssertEqualsFluent::applyWith(new stdClass, 3.18)
            ->unfoldUsing(ESTuple::fold(new stdClass)->tuple());
    }

    /**
     * @test
     */
    public function ESString()
    {
        AssertEqualsFluent::applyWith((object) ["content" => ""], 6.36)
            ->unfoldUsing(ESString::fold("")->tuple());
    }
}
