<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestClasses\TestCase;
use Eightfold\Shoop\Tests\TestClasses\AssertEquals;

use \stdClass;

use Eightfold\Shoop\Filter\TypesOf;

/**
 * @group TypeChecking
 * @group  TypeOf
 *
 * TODO: MaxMS = 0.01
 */
class TypesOfTest extends TestCase
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
            ["sequential", "number", "integer"],
            TypesOf::apply(),
            0.03 // 0.01
        )->unfoldUsing(1);

        AssertEquals::applyWith(
            ["sequential", "number", "integer", "float"],
            TypesOf::apply(),
            0.03 // 0.01
        )->unfoldUsing(1.0);

        AssertEquals::applyWith(
            ["sequential", "number", "float"],
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
            ["sequential", "string"],
            TypesOf::apply(),
            0.03 // 0.01
        )->unfoldUsing("8fold!");

        AssertEquals::applyWith(
            ["collection", "tuple", "json"],
            TypesOf::apply(),
            0.011
        )->unfoldUsing("{}");

        AssertEquals::applyWith(
            ["sequential", "string"],
            TypesOf::apply(),
            0.01
        )->unfoldUsing("{hello}");

        AssertEquals::applyWith(
            ["collection", "tuple", "json"],
            TypesOf::apply(),
            0.01
        )->unfoldUsing('{"hello":true}');

        AssertEquals::applyWith(
            ["sequential", "string"],
            TypesOf::apply(),
            0.01
        )->unfoldUsing("{something");

        AssertEquals::applyWith(
            ["sequential", "string"],
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
            ["sequential", "collection", "list", "array"],
            TypesOf::apply(),
            0.03 // 0.02
        )->unfoldUsing([0, 1, 2]);

        AssertEquals::applyWith(
            ["sequential", "collection", "list", "array"],
            TypesOf::apply(),
            0.02 // 0.01
        )->unfoldUsing([3 => "8fold", 4 => true]);

        AssertEquals::applyWith(
            ["collection", "list", "dictionary"],
            TypesOf::apply(),
            0.04 // 0.02 // 0.01
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
            0.03 // 0.02 // 0.01
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
