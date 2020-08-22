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
 * @group  BooleanFluent
 *
 * The `boolean()` method converts the Shoop type to an `ESBoolean` type.
 *
 * @return Eightfold\Shoop\ESBoolean
 */
class BoolTest extends TestCase
{
    /**
     * @test
     */
    public function ESArray()
    {
        AssertEqualsFluent::applyWith(true, 6.43)
            ->unfoldUsing(ESArray::fold(["testing"])->boolean());

        AssertEqualsFluent::applyWith(false)
            ->unfoldUsing(ESArray::fold([])->boolean());
    }

    /**
     * @test
     */
    public function ESBoolean()
    {
        AssertEqualsFluent::applyWith(true, 1.26)
            ->unfoldUsing(ESBoolean::fold(true)->boolean());

        AssertEqualsFluent::applyWith(false)
            ->unfoldUsing(ESBoolean::fold(false)->boolean());
    }

    /**
     * @test
     */
    public function ESDictionary()
    {
        AssertEqualsFluent::applyWith(false, 1.39)
            ->unfoldUsing(ESDictionary::fold([])->boolean());
    }

    /**
     * @test
     */
    public function ESInteger()
    {
        AssertEqualsFluent::applyWith(true, 1.59)
            ->unfoldUsing(ESInteger::fold(1)->boolean());

        AssertEqualsFluent::applyWith(false)
            ->unfoldUsing(ESInteger::fold(0)->boolean());
    }

    /**
     * @test
     */
    public function ESJson()
    {
        AssertEqualsFluent::applyWith(true, 2.39)
            ->unfoldUsing(ESJson::fold('{"test":"test"}')->boolean());

        AssertEqualsFluent::applyWith(false)
            ->unfoldUsing(ESJson::fold('{}')->boolean());
    }

    /**
     * @test
     */
    public function ESTuple()
    {
        $using = new \stdClass();

        AssertEqualsFluent::applyWith(false, 1.37)
            ->unfoldUsing(ESTuple::fold($using)->boolean());

        $using->name = "hello";

        AssertEqualsFluent::applyWith(true)
            ->unfoldUsing(ESTuple::fold($using)->boolean());
    }

    /**
     * @test
     */
    public function ESString()
    {
        AssertEqualsFluent::applyWith(false, 2.52)
            ->unfoldUsing(ESString::fold("")->boolean());

        AssertEqualsFluent::applyWith(true)
            ->unfoldUsing(ESString::fold("hello")->boolean());
    }
}
