<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;
use Eightfold\Shoop\Tests\AssertEquals;

use \stdClass;

use Eightfold\Shoop\Filter\At;

/**
 * @group At
 */
class AtTest extends TestCase
{
    /**
     * @test
     */
    public function booleans()
    {
        AssertEquals::applyWith(
            true,
            At::applyWith(1),
            3.52
        )->unfoldUsing(true);

        AssertEquals::applyWith(
            true,
            At::applyWith("false")
        )->unfoldUsing(false);
    }

    /**
     * @test
     */
    public function numbers()
    {
        $using = 5;

        AssertEquals::applyWith(
            2,
            At::applyWith(2),
            0.9
        )->unfoldUsing(5);

        AssertEquals::applyWith(
            [0.0, 2.0],
            At::applyWith([0, 2]),
            1.06
        )->unfoldUsing(6.5);
    }

    /**
     * @test
     */
    public function strings()
    {
        AssertEquals::applyWith(
            "Ryg!",
            At::applyWith([0, 6, 11, 16]),
            3.21
        )->unfoldUsing("Raise your glass!");
    }

    /**
     * @test
     */
    public function lists()
    {
        AssertEquals::applyWith(
            4,
            At::applyWith(1),
            0.36
        )->unfoldUsing([3, 4, 5]);

        AssertEquals::applyWith(
            ["first" => "hello", "third" => 3],
            At::applyWith(["first", "third"])
        )->unfoldUsing(["first" => "hello", "second" => false, "third" => 3]);

        AssertEquals::applyWith(
            [4, 5],
            At::applyWith([1, 2])
        )->unfoldUsing([3, 4, 5]);
    }

    /**
     * @test
     */
    public function tuples()
    {
        $using = (object) ["first" => 0, "second" => true];

        AssertEquals::applyWith(
            $using,
            At::applyWith(["first", "second"]),
            1.16
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            true,
            At::applyWith("second")
        )->unfoldUsing($using);

        $using = json_encode($using);

        AssertEquals::applyWith(
            true,
            At::applyWith("second"),
            1.31
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            (object) ["first" => 0, "second" => true],
            At::applyWith(["first", "second"])
        )->unfoldUsing($using);
    }
}
