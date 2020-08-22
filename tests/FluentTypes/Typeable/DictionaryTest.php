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
 * @group Typeable
 * @group  DictionaryFluent
 *
 * The `dictionary()` method converts the Shoop type to the `PHP associative array` equivalent.
 *
 * @return Eightfold\Shoop\ESDictionary
 */
class DictionaryTest extends TestCase
{
    /**
     * @test
     */
    public function ESArray()
    {
        AssertEqualsFluent::applyWith(["i0" => "hi"], 1.64)
            ->unfoldUsing(ESArray::fold(["hi"])->dictionary());
    }

    /**
     * @test
     */
    public function ESBoolean()
    {
        AssertEqualsFluent::applyWith(["true" => true, "false" => false], 1.8)
            ->unfoldUsing(ESBoolean::fold(true)->dictionary());
    }

    /**
     * @test
     */
    public function ESDictionary()
    {
        AssertEqualsFluent::applyWith(["hello" => "world"], 1.37)
            ->unfoldUsing(
                ESDictionary::fold(["hello" => "world"])->dictionary()
            );
    }

    /**
     * @test
     */
    public function ESInteger()
    {
        AssertEqualsFluent::applyWith(["i0" => 0, "i1" => 1, "i2" => 2], 1.74)
            ->unfoldUsing(ESInteger::fold(2)->dictionary());
    }

    /**
     * @test
     */
    public function ESJson()
    {
        AssertEqualsFluent::applyWith(["test" => true], 1.84)
            ->unfoldUsing(ESJson::fold('{"test":true}')->dictionary());
    }

    /**
     * @test
     */
    public function ESTuple()
    {
        AssertEqualsFluent::applyWith(["test" => true], 1.67)
            ->unfoldUsing(ESTuple::fold((object) ["test" => true])->dictionary());
    }

    /**
     * @test
     */
    public function ESString()
    {
        AssertEqualsFluent::applyWith(["content" => "hello"], 3.26)
            ->unfoldUsing(ESString::fold("hello")->dictionary());
    }
}
