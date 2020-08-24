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
        AssertEqualsFluent::applyWith(
            "",
            ESString::class,
            9.19
        )->unfoldUsing(
            Shoop::this([])->asString()
        );

        AssertEqualsFluent::applyWith(
            "testing something",
            ESString::class
        )->unfoldUsing(
            Shoop::this(["testing", " something"])->asString()
        );
    }

    /**
     * @test
     */
    public function ESBoolean()
    {
        AssertEqualsFluent::applyWith("true", 2.87)
            ->unfoldUsing(ESBoolean::fold(true)->asString());
    }

    /**
     * @test
     */
    public function ESDictionary()
    {
        AssertEqualsFluent::applyWith(
            "",
            ESString::class,
            2.08
        )->unfoldUsing(
            Shoop::this([])->asString()
        );
    }

    /**
     * @test
     */
    public function ESInteger()
    {
        AssertEqualsFluent::applyWith(
            "1",
            ESString::class,
            2.56
        )->unfoldUsing(
            Shoop::this(1)->asString()
        );
    }

    /**
     * @test
     */
    public function ESJson()
    {
        AssertEqualsFluent::applyWith(
            "test",
            ESString::class,
            3.15
        )->unfoldUsing(
            Shoop::this('{"test":"test"}')->asString()
        );
    }

    /**
     * @test
     */
    public function ESTuple()
    {
        AssertEqualsFluent::applyWith(
            "",
            ESString::class
        )->unfoldUsing(
            Shoop::this(new stdClass)->asString()
        );
    }

    /**
     * @test
     */
    public function ESString()
    {
        AssertEqualsFluent::applyWith(
            "hello",
            ESString::class,
            1.66
        )->unfoldUsing(
            Shoop::this("hello")->asString()
        );
    }
}
