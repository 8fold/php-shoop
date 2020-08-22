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
 * @group StringFluent
 *
 * The `string()` method converts the Shoop type to a PHP string representation.
 *
 * @return Eightfold\Shoop\FluentTypes\ESString
 */
class StringTest extends TestCase
{
    /**
     * @test
     */
    public function ESArray()
    {
        AssertEqualsFluent::applyWith("", 9.19)
            ->unfoldUsing(ESArray::fold([])->string());

        AssertEqualsFluent::applyWith("testing something")
            ->unfoldUsing(ESArray::fold(["testing", " something"])->string());
    }

    /**
     * @test
     */
    public function ESBoolean()
    {
        AssertEqualsFluent::applyWith("true", 2.87)
            ->unfoldUsing(ESBoolean::fold(true)->string());
    }

    /**
     * @test
     */
    public function ESDictionary()
    {
        AssertEqualsFluent::applyWith("", 2.08)
            ->unfoldUsing(ESDictionary::fold([])->string());
    }

    /**
     * @test
     */
    public function ESInteger()
    {
        AssertEqualsFluent::applyWith("1", 2.56)
            ->unfoldUsing(ESInteger::fold(1)->string());
    }

    /**
     * @test
     */
    public function ESJson()
    {
        AssertEqualsFluent::applyWith("test", 3.15)
            ->unfoldUsing(ESJson::fold('{"test":"test"}')->string());
    }

    /**
     * @test
     */
    public function ESTuple()
    {
        AssertEqualsFluent::applyWith("")
            ->unfoldUsing(ESJson::fold(new stdClass)->string());
    }

    /**
     * @test
     */
    public function ESString()
    {
        AssertEqualsFluent::applyWith("hello", 1.66)
            ->unfoldUsing(ESString::fold("hello")->string());
    }
}
