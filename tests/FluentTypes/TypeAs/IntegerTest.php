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
 * @group IntegerFluent
 *
 * The `int()` method converts the Shoop type to the `PHP integer` equivalent.
 *
 * @return Eightfold\Shoop\ESInteger
 */
class IntegerTest extends TestCase
{
    /**
     * @test
     */
    public function ESArray()
    {
        AssertEqualsFluent::applyWith(1, 1.58)
            ->unfoldUsing(ESArray::fold(['testing'])->asInteger());
    }

    /**
     * @test
     */
    public function ESBoolean()
    {
        AssertEqualsFluent::applyWith(1, 1.92)
            ->unfoldUsing(ESBoolean::fold(true)->asInteger());

        AssertEqualsFluent::applyWith(0)
            ->unfoldUsing(ESBoolean::fold(false)->asInteger());
    }

    /**
     * @test
     */
    public function ESDictionary()
    {
        AssertEqualsFluent::applyWith(0, 1.56)
            ->unfoldUsing(ESDictionary::fold([])->asInteger());
    }

    /**
     * @test
     */
    public function ESInteger()
    {
        AssertEqualsFluent::applyWith(1, 1.51)
            ->unfoldUsing(ESInteger::fold(1)->asInteger());
    }

    /**
     * @test
     */
    public function ESJson()
    {
        AssertEqualsFluent::applyWith(1, 2.31)
            ->unfoldUsing(ESJson::fold('{"test":"test"}')->asInteger());
    }

    /**
     * @test
     */
    public function ESTuple()
    {
        AssertEqualsFluent::applyWith(0, 3.34)
            ->unfoldUsing(ESTuple::fold(new stdClass)->asInteger());
    }

    /**
     * @test
     */
    public function ESString()
    {
        AssertEqualsFluent::applyWith(1, 2.59)
            ->unfoldUsing(ESString::fold("0")->asInteger());

        AssertEqualsFluent::applyWith(5)
            ->unfoldUsing(ESString::fold("hello")->asInteger());
    }
}
