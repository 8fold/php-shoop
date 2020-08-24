<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;
use Eightfold\Shoop\Tests\AssertEqualsFluent;

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
 * @group  BooleanFluent
 *
 * The `boolean()` method converts the Shoop type to an `ESBoolean` type.
 *
 * @return Eightfold\Shoop\ESBoolean
 */
class BooleanTest extends TestCase
{
    /**
     * @test
     */
    public function ESArray()
    {
        AssertEqualsFluent::applyWith(true, 6.43)
            ->unfoldUsing(ESArray::fold(["testing"])->asBoolean());

        AssertEqualsFluent::applyWith(false)
            ->unfoldUsing(
                ESArray::fold([])->asBoolean()
            );
    }

    /**
     * @test
     */
    public function ESBoolean()
    {
        AssertEqualsFluent::applyWith(true, 1.26)
            ->unfoldUsing(ESBoolean::fold(true)->asBoolean());

        AssertEqualsFluent::applyWith(false)
            ->unfoldUsing(ESBoolean::fold(false)->asBoolean());
    }

    /**
     * @test
     */
    public function ESDictionary()
    {
        AssertEqualsFluent::applyWith(false, 1.39)
            ->unfoldUsing(ESDictionary::fold([])->asBoolean());
    }

    /**
     * @test
     */
    public function ESInteger()
    {
        AssertEqualsFluent::applyWith(true, 1.59)
            ->unfoldUsing(ESInteger::fold(1)->asBoolean());

        AssertEqualsFluent::applyWith(false)
            ->unfoldUsing(ESInteger::fold(0)->asBoolean());
    }

    /**
     * @test
     */
    public function ESJson()
    {
        AssertEqualsFluent::applyWith(true, 2.39)
            ->unfoldUsing(ESJson::fold('{"test":"test"}')->asBoolean());

        AssertEqualsFluent::applyWith(false)
            ->unfoldUsing(ESJson::fold('{}')->asBoolean());
    }

    /**
     * @test
     */
    public function ESTuple()
    {
        $using = new \stdClass();

        AssertEqualsFluent::applyWith(false, 1.37)
            ->unfoldUsing(ESTuple::fold($using)->asBoolean());

        $using->name = "hello";

        AssertEqualsFluent::applyWith(true)
            ->unfoldUsing(ESTuple::fold($using)->asBoolean());
    }

    /**
     * @test
     */
    public function ESString()
    {
        AssertEqualsFluent::applyWith(false, 2.52)
            ->unfoldUsing(ESString::fold("")->asBoolean());

        AssertEqualsFluent::applyWith(true)
            ->unfoldUsing(ESString::fold("hello")->asBoolean());
    }
}
