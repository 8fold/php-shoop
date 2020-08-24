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
 * @group JsonFluent
 *
 * The `json()` method converts the Shoop type to a representation using JSON.
 *
 * @return Eightfold\Shoop\FluentTypes\ESString In JSON.
 */
class JsonTest extends TestCase
{
    /**
     * @test
     */
    public function ESArray()
    {
        AssertEqualsFluent::applyWith('{}', 3.67)
            ->unfoldUsing(ESArray::fold([])->asJson());

        AssertEqualsFluent::applyWith('{"i0":"testing"}', 2.93)
            ->unfoldUsing(ESArray::fold(['testing'])->asJson());
    }

    /**
     * @test
     */
    public function ESBoolean()
    {
        AssertEqualsFluent::applyWith('{"false":false,"true":true}', 2)
            ->unfoldUsing(ESBoolean::fold(true)->asJson());
    }

    /**
     * @test
     */
    public function ESDictionary()
    {
        AssertEqualsFluent::applyWith('{}', 2.4)
            ->unfoldUsing(ESDictionary::fold([])->asJson());
    }

    /**
     * @test
     */
    public function ESInteger()
    {
        AssertEqualsFluent::applyWith('{"i0":0,"i1":1}', 3.29)
            ->unfoldUsing(ESInteger::fold(1)->asJson());
    }

    /**
     * @test
     */
    public function ESJson()
    {
        AssertEqualsFluent::applyWith('{"test":"test"}', 1.55)
            ->unfoldUsing(ESJson::fold('{"test":"test"}')->asJson());
    }

    /**
     * @test
     */
    public function ESTuple()
    {
        AssertEqualsFluent::applyWith('{}', 11.35)
            ->unfoldUsing(ESTuple::fold(new stdClass)->asJson());
    }

    /**
     * @test
     */
    public function ESString()
    {
        AssertEqualsFluent::applyWith('{"scalar":"hello"}', 7.99)
            ->unfoldUsing(ESString::fold('{"scalar":"hello"}')->asJson());
    }
}
