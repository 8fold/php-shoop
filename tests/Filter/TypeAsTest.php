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
            17 // 16
        )->unfoldUsing(
            Type::asBoolean()->unfoldUsing(true)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.04, // 0.03, // 0.02, // 0.01, // 0.004,
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
            0,
            "integer",
            0.43, // 0.38, // 0.36, // 0.34, // 0.29,
            22 // 20 // 19 // 15
        )->unfoldUsing(
            Type::asNumber()->unfoldUsing(false)
        );

        AssertEquals::applyWith(
            1,
            "integer",
            0.18, // 0.17, // 0.15, // 0.14,
            5 // 4
        )->unfoldUsing(
            Type::asNumber()->unfoldUsing(1)
        );

        AssertEquals::applyWith(
            1,
            "integer",
            0.04, // 0.03, // 0.01, // 0.005,
            1
        )->unfoldUsing(
            Type::asInteger()->unfoldUsing(1.0)
        );

        AssertEquals::applyWith(
            1.1,
            "double",
            0.05, // 0.04, // 0.03, // 0.004,
            1
        )->unfoldUsing(
            Type::asNumber()->unfoldUsing(1.1)
        );
    }

    /**
     * @test
     */
    public function strings()
    {
        AssertEquals::applyWith(
            "",
            "string",
            0.51, // 0.45, // 0.37, // 0.34,
            21 // 18
        )->unfoldUsing(
            Type::asString()->unfoldUsing("")
        );

        AssertEquals::applyWith(
            "8fold!",
            "string",
            0.05, // 0.02, // 0.01,
            1
        )->unfoldUsing(
            Type::asString()->unfoldUsing("8fold!")
        );

        AssertEquals::applyWith(
            "",
            "string",
            0.58, // 0.57, // 0.06, // 0.53, // 0.5,
            96
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
            [],
            "array",
            0.4,
            81
        )->unfoldUsing(
            Type::asArray()->unfoldUsing([])
        );

        AssertEquals::applyWith(
            [0, 1, 2],
            "array",
            0.08, // 0.05, // 0.02, // 0.01,
            1
        )->unfoldUsing(
            Type::asArray()->unfoldUsing([0, 1, 2])
        );

        AssertEquals::applyWith(
            ["0.0" => 0, "1.0" => 1, "2.0" => 2],
            "array",
            0.28, // 0.21, // 0.19, // 0.001,
            17
        )->unfoldUsing(
            Type::asDictionary()->unfoldUsing([0, 1, 2])
        );

        AssertEquals::applyWith(
            ["8fold", true],
            "array",
            0.05, // 0.01, // 0.005,
            1
        )->unfoldUsing(
            Type::asArray()
                ->unfoldUsing([3 => "8fold", 4 => true])
        );

        AssertEquals::applyWith(
            [1, 2, 3],
            "array",
            0.05, // 0.005, // 0.004,
            1
        )->unfoldUsing(
            Type::asArray()->unfoldUsing(["a" => 1, "b" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            ["a" => 1, "1.0" => 2, "c" => 3],
            "array",
            0.07, // 0.06, // 0.01,
            1
        )->unfoldUsing(
            Type::asDictionary()->unfoldUsing(["a" => 1, 1 => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            [],
            "array",
            0.01,
            1
        )->unfoldUsing(
            Type::asDictionary()->unfoldUsing(new stdClass)
        );

        $expected = new stdClass;
        $expected->public = "content";

        AssertEquals::applyWith(
            $expected,
            "object",
            0.19, // 0.14,
            10
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
        $expected = new stdClass;
        $expected->public = "content";

        AssertEquals::applyWith(
            $expected,
            "object",
            0.65, // 0.6,
            102
        )->unfoldUsing(
            Type::asTuple()->unfoldUsing(
                new class {
                    public $public = "content";
                    private $private = "private";
                }
            )
        );

        AssertEquals::applyWith(
            $expected,
            "object",
            0.2, // 0.19, // 0.17, // 0.13, // 0.12, // 0.02, // 0.01,
            2
        )->unfoldUsing(
            Type::asTuple()->unfoldUsing(
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
