<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use \stdClass;

use Eightfold\Shoop\Filter\Type;

/**
 * @group TypeChecking
 *
 * @group  TypeAs
 */
class TypeAsTest extends TestCase
{
    /**
     * @test
     */
    public function boolean()
    {
        AssertEquals::applyWith(
            true,
            "boolean",
            0.74,
            1
        )->unfoldUsing(
            Type::asBoolean()->unfoldUsing(true)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Type::asBoolean()->unfoldUsing(false)
        );
    }

    /**
     * @test
     */
    public function numbers()
    {
        AssertEquals::applyWith(
            true,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Type::asNumber()->unfoldUsing(false)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Type::asNumber()->unfoldUsing(1)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Type::asNumber()->unfoldUsing(1)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Type::asInteger()->unfoldUsing(1.0)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Type::asFloat()->unfoldUsing(1.0)
        );
    }

    /**
     * @test
     */
    public function strings()
    {
        AssertEquals::applyWith(
            true,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Type::asString()->unfoldUsing("")
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Type::asString()->unfoldUsing("8fold!")
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Type::asString()->unfoldUsing("{}")
        );
    }

    /**
     * @test
     */
    public function collections()
    {
        AssertEquals::applyWith(
            true,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Type::asCollection()->unfoldUsing([])
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Type::asList()->unfoldUsing([0, 1, 2])
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Type::asArray()->unfoldUsing([0, 1, 2])
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Type::asArray()
                ->unfoldUsing([3 => "8fold", 4 => true])
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Type::asArray()->unfoldUsing(["a" => 1, "b" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Type::asDictionary()->unfoldUsing(["a" => 1, 1 => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Type::asDictionary()->unfoldUsing(["a" => 1, "b" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Type::asCollection()->unfoldUsing(new stdClass)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Type::asTuple()->unfoldUsing(
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
            false,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Type::asObject()->unfoldUsing(
                new class {
                    public $public = "content";
                    private $private = "private";
                }
            )
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.001,
            1
        )->unfoldUsing(
            Type::asObject()->unfoldUsing(
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
