<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;
use Eightfold\Shoop\Tests\AssertEquals;

use \stdClass;

use Eightfold\Shoop\Filter\TypeIs;

/**
 * @group TypeChecking
 *
 * @group  TypeIs
 */
class TypeIsTest extends TestCase
{
    /**
     * @test
     */
    public function boolean()
    {
        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("boolean"),
            0.25
        )->unfoldUsing(true);

        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("boolean")
        )->unfoldUsing(false);
    }

    /**
     * @test
     */
    public function numbers()
    {
        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("number")
        )->unfoldUsing(1);

        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("integer")
        )->unfoldUsing(1);

        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("integer")
        )->unfoldUsing(1.0);

        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("float")
        )->unfoldUsing(1.0);
    }

    /**
     * @test
     */
    public function strings()
    {
        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("string")
        )->unfoldUsing("");

        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("string")
        )->unfoldUsing("8fold!");

        AssertEquals::applyWith(
            false,
            TypeIs::applyWith("string")
        )->unfoldUsing("{}");

        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("json")
        )->unfoldUsing("{}");

        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("tuple")
        )->unfoldUsing("{}");

        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("collection")
        )->unfoldUsing("{}");

        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("string")
        )->unfoldUsing("{hello}");

        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("json")
        )->unfoldUsing('{"hello":true}');

        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("string")
        )->unfoldUsing("{something");

        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("string")
        )->unfoldUsing("somehing}");
    }

    /**
     * @test
     */
    public function collections()
    {
        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("collection")
        )->unfoldUsing([]);

        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("list")
        )->unfoldUsing([]);

        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("array")
        )->unfoldUsing([0, 1, 2]);

        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("list")
        )->unfoldUsing([0, 1, 2]);

        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("array")
        )->unfoldUsing([3 => "8fold", 4 => true]);

        AssertEquals::applyWith(
            false,
            TypeIs::applyWith("array")
        )->unfoldUsing(["a" => 1, "b" => 2, "c" => 3]);

        AssertEquals::applyWith(
            false,
            TypeIs::applyWith("dictionary")
        )->unfoldUsing(["a" => 1, 1 => 2, "c" => 3]);

        AssertEquals::applyWith(
            false,
            TypeIs::applyWith("array")
        )->unfoldUsing(["a" => 1, 1 => 2, "c" => 3]);

        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("collection")
        )->unfoldUsing(["a" => 1, 1 => 2, "c" => 3]);

        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("list")
        )->unfoldUsing(["a" => 1, 1 => 2, "c" => 3]);

        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("tuple")
        )->unfoldUsing(new stdClass);

        AssertEquals::applyWith(
            true,
            TypeIs::applyWith("tuple")
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
            true,
            TypeIs::applyWith("object")
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
