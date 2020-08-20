<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;
use Eightfold\Shoop\Tests\AssertEquals;

use \stdClass;

use Eightfold\Shoop\PipeFilters\TypeOf;

/**
 * @group TypeChecking
 *
 * TODO: MaxMS = 0.01
 */
class TypeOfTest extends TestCase
{
    /**
     * @test
     */
    public function boolean()
    {
        AssertEquals::applyWith(
            ["boolean"],
            TypeOf::apply()
        )->unfoldUsing(true);

        AssertEquals::applyWith(
            ["boolean"],
            TypeOf::apply()
        )->unfoldUsing(false);
    }

    /**
     * @test
     */
    public function numbers()
    {
        AssertEquals::applyWith(
            ["number", "integer"],
            TypeOf::apply()
        )->unfoldUsing(1);

        AssertEquals::applyWith(
            ["number", "integer", "float"],
            TypeOf::apply()
        )->unfoldUsing(1.0);

        AssertEquals::applyWith(
            ["number", "float"],
            TypeOf::apply()
        )->unfoldUsing(1.1);
    }

    /**
     * @test
     */
    public function strings()
    {
        AssertEquals::applyWith(
            ["string"],
            TypeOf::apply()
        )->unfoldUsing("8fold!");

        AssertEquals::applyWith(
            ["string", "collection", "tuple", "json"],
            TypeOf::apply()
        )->unfoldUsing("{}");

        AssertEquals::applyWith(
            ["string"],
            TypeOf::apply()
        )->unfoldUsing("{hello}");

        AssertEquals::applyWith(
            ["string", "collection", "tuple", "json"],
            TypeOf::apply()
        )->unfoldUsing('{"hello":true}');

        AssertEquals::applyWith(
            ["string"],
            TypeOf::apply()
        )->unfoldUsing("{something");

        AssertEquals::applyWith(
            ["string"],
            TypeOf::apply()
        )->unfoldUsing("somehing}");
    }

    /**
     * @test
     *
     * @group current
     */
    public function collections()
    {
        AssertEquals::applyWith(
            ["collection", "list"],
            TypeOf::apply()
        )->unfoldUsing([]);

        AssertEquals::applyWith(
            ["collection", "list", "array"],
            TypeOf::apply()
        )->unfoldUsing([0, 1, 2]);

        AssertEquals::applyWith(
            ["collection", "list", "array"],
            TypeOf::apply()
        )->unfoldUsing([3 => "8fold", 4 => true]);

        AssertEquals::applyWith(
            ["collection", "list", "dictionary"],
            TypeOf::apply()
        )->unfoldUsing(["a" => 1, "b" => 2, "c" => 3]);

        AssertEquals::applyWith(
            ["collection", "tuple"],
            TypeOf::apply()
        )->unfoldUsing(new stdClass);

        AssertEquals::applyWith(
            ["collection", "tuple"],
            TypeOf::apply()
        )->unfoldUsing(
            new class {
                public $public = "content";
                private $private = "private";
            }
        );
    }

    /**
     * @test
     */
    public function objects()
    {
        AssertEquals::applyWith(
            ["object"],
            TypeOf::apply()
        )->unfoldUsing(
            new class {
                public $public = "content";
                private $private = "private";
                public function someAction()
                {
                    return false;
                }
            }
        );
    }
}
