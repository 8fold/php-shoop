<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;
use Eightfold\Shoop\Tests\AssertEquals;

use \stdClass;

use Eightfold\Shoop\Filter\TypesOf;

/**
 * @group TypeChecking
 * @group  TypeOf
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
            TypesOf::apply(),
            0.01
        )->unfoldUsing(true);

        AssertEquals::applyWith(
            ["boolean"],
            TypesOf::apply(),
            0.01
        )->unfoldUsing(false);
    }

    /**
     * @test
     */
    public function numbers()
    {
        AssertEquals::applyWith(
            ["number", "integer"],
            TypesOf::apply(),
            0.01
        )->unfoldUsing(1);

        AssertEquals::applyWith(
            ["number", "integer", "float"],
            TypesOf::apply(),
            0.01
        )->unfoldUsing(1.0);

        AssertEquals::applyWith(
            ["number", "float"],
            TypesOf::apply(),
            0.01
        )->unfoldUsing(1.1);
    }

    /**
     * @test
     */
    public function strings()
    {
        AssertEquals::applyWith(
            ["string"],
            TypesOf::apply(),
            0.01
        )->unfoldUsing("8fold!");

        AssertEquals::applyWith(
            ["collection", "tuple", "json"],
            TypesOf::apply(),
            0.011
        )->unfoldUsing("{}");

        AssertEquals::applyWith(
            ["string"],
            TypesOf::apply(),
            0.01
        )->unfoldUsing("{hello}");

        AssertEquals::applyWith(
            ["collection", "tuple", "json"],
            TypesOf::apply(),
            0.01
        )->unfoldUsing('{"hello":true}');

        AssertEquals::applyWith(
            ["string"],
            TypesOf::apply(),
            0.01
        )->unfoldUsing("{something");

        AssertEquals::applyWith(
            ["string"],
            TypesOf::apply(),
            0.01
        )->unfoldUsing("somehing}");
    }

    /**
     * @test
     */
    public function collections()
    {
        AssertEquals::applyWith(
            ["collection", "list"],
            TypesOf::apply(),
            0.01
        )->unfoldUsing([]);

        AssertEquals::applyWith(
            ["collection", "list", "array"],
            TypesOf::apply(),
            0.01
        )->unfoldUsing([0, 1, 2]);

        AssertEquals::applyWith(
            ["collection", "list", "array"],
            TypesOf::apply(),
            0.01
        )->unfoldUsing([3 => "8fold", 4 => true]);

        AssertEquals::applyWith(
            ["collection", "list", "dictionary"],
            TypesOf::apply(),
            0.01
        )->unfoldUsing(["a" => 1, "b" => 2, "c" => 3]);

        AssertEquals::applyWith(
            ["collection", "tuple"],
            TypesOf::apply(),
            0.01
        )->unfoldUsing(new stdClass);

        AssertEquals::applyWith(
            ["collection", "tuple"],
            TypesOf::apply(),
            0.01
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
            TypesOf::apply(),
            0.01
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
