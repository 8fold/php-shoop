<?php

namespace Eightfold\Shoop\Tests\MathOperations;

use PHPUnit\Framework\TestCase;
use Eightfold\Shoop\Tests\AssertEquals;

use \stdClass;

use Eightfold\Shoop\PipeFilters\Plus;

/**
 * @group Plus
 */
class PlusTest extends TestCase
{
    /**
     * @test
     */
    public function boolean()
    {
        AssertEquals::applyWith(
            true,
            Plus::apply(),
            5.62 //very inconsistant - less than 1
        )->unfoldUsing(true);

        AssertEquals::applyWith(
            true,
            Plus::applyWith(1)
        )->unfoldUsing(false);

        AssertEquals::applyWith(
            false,
            Plus::applyWith(-1)
        )->unfoldUsing(true);
    }

    /**
     * @test
     */
    public function number()
    {
        AssertEquals::applyWith(
            1,
            Plus::apply(),
            1.04
        )->unfoldUsing(1);

        AssertEquals::applyWith(
            2,
            Plus::applyWith(1)
        )->unfoldUsing(1);

        AssertEquals::applyWith(
            0.3,
            Plus::applyWith(1.5)
        )->unfoldUsing(-1.2);

        AssertEquals::applyWith(
            -12,
            Plus::applyWith(-6.5)
        )->unfoldUsing(-5.5);
    }

    /**
     * @test
     */
    public function lists()
    {
        AssertEquals::applyWith(
            [1, "string", true, "string inserted"],
            Plus::applyWith("string inserted")
        )->unfoldUsing([1, "string", true]);

        AssertEquals::applyWith(
            [1, "string", true, "string inserted"],
            Plus::applyWith([12 => "string inserted"])
        )->unfoldUsing([1, "string", true]);

        AssertEquals::applyWith(
            [
                "one" => 1,
                "stringKey" => "string",
                "true" => true,
                "inserted" => (object) ["string" => ""]
            ],
            Plus::applyWith(["inserted" => (object) ["string" => ""]])
        )->unfoldUsing(["one" => 1, "stringKey" => "string", "true" => true]);
    }

    /**
     * @test
     */
    public function string()
    {
        AssertEquals::applyWith(
            "Do you remember when, we used to sing?",
            Plus::applyWith(" sing?")
        )->unfoldUsing("Do you remember when, we used to");

        AssertEquals::applyWith(
            "Do you remember when, we used to sing?",
            Plus::applyWith("Do you ", true)
        )->unfoldUsing("remember when, we used to sing?");
    }
}
