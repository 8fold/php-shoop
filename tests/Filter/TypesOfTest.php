<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use \stdClass;

use Eightfold\Shoop\Filter\TypesOf;

/**
 * @group TypeChecking
 * @group TypesOf
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
            "array",
            0.42
        )->unfoldUsing(
            TypesOf::apply()->unfoldUsing(true)
        );

        AssertEquals::applyWith(
            ["boolean"],
            "array"
        )->unfoldUsing(
            TypesOf::apply()->unfoldUsing(false)
        );
    }

    /**
     * @test
     */
    public function numbers()
    {
        AssertEquals::applyWith(
            ["sequential", "number", "integer"],
            "array"
        )->unfoldUsing(
            TypesOf::apply()->unfoldUsing(1)
        );

        AssertEquals::applyWith(
            ["sequential", "number", "integer", "float"],
            "array"
        )->unfoldUsing(
            TypesOf::apply()->unfoldUsing(1.0)
        );

        AssertEquals::applyWith(
            ["sequential", "number", "float"],
            "array"
        )->unfoldUsing(
            TypesOf::apply()->unfoldUsing(1.1)
        );
    }

    /**
     * @test
     */
    public function strings()
    {
        AssertEquals::applyWith(
            ["sequential", "string"],
            "array"
        )->unfoldUsing(
            TypesOf::apply()->unfoldUsing("8fold!")
        );

        AssertEquals::applyWith(
            ["collection", "tuple", "json"],
            "array"
        )->unfoldUsing(
            TypesOf::apply()->unfoldUsing("{}")
        );

        AssertEquals::applyWith(
            ["sequential", "string"],
            "array"
        )->unfoldUsing(
            TypesOf::apply()->unfoldUsing("{hello}")
        );

        AssertEquals::applyWith(
            ["collection", "tuple", "json"],
            "array"
        )->unfoldUsing(
            TypesOf::apply()->unfoldUsing('{"hello":true}')
        );

        AssertEquals::applyWith(
            ["sequential", "string"],
            "array"
        )->unfoldUsing(
            TypesOf::apply()->unfoldUsing("{something")
        );

        AssertEquals::applyWith(
            ["sequential", "string"],
            "array"
        )->unfoldUsing(
            TypesOf::apply()->unfoldUsing("somehing}")
        );
    }

    /**
     * @test
     */
    public function collections()
    {
        AssertEquals::applyWith(
            ["collection", "list"],
            "array"
        )->unfoldUsing(
            TypesOf::apply()->unfoldUsing([])
        );

        AssertEquals::applyWith(
            ["sequential", "collection", "list", "array"],
            "array"
        )->unfoldUsing(
            TypesOf::apply()->unfoldUsing([0, 1, 2])
        );

        AssertEquals::applyWith(
            ["sequential", "collection", "list", "array"],
            "array"
        )->unfoldUsing(
            TypesOf::apply()->unfoldUsing([3 => "8fold", 4 => true])
        );

        AssertEquals::applyWith(
            ["collection", "list", "dictionary"],
            "array"
        )->unfoldUsing(
            TypesOf::apply()->unfoldUsing(["a" => 1, "b" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            ["collection", "tuple"],
            "array"
        )->unfoldUsing(
            TypesOf::apply()->unfoldUsing(new stdClass)
        );

        AssertEquals::applyWith(
            ["collection", "tuple"],
            "array"
        )->unfoldUsing(
            TypesOf::apply()->unfoldUsing(
                new class {
                    public $public = "content";
                    private $private = "private";
                }
            )
        );
    }

    /**
     * @test
     */
    public function objects()
    {
        AssertEquals::applyWith(
            ["object"],
            "array"
        )->unfoldUsing(
            TypesOf::apply()->unfoldUsing(
                new class {
                    public $public = "content";
                    private $private = "private";
                    public function someAction()
                    {
                        return false;
                    }
                }
            )
        );
    }
}
