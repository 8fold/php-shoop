<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use \stdClass;

use Eightfold\Shoop\Filter\Type;

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
            "boolean",
            0.62,
            89
        )->unfoldUsing(
            Type::isBoolean()->unfoldUsing(true)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.02, // 0.01,
            1
        )->unfoldUsing(
            Type::isBoolean()->unfoldUsing(false)
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
            0.83, // 0.66, // 0.59,
            89
        )->unfoldUsing(
            Type::isNumber()->unfoldUsing(1)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.73,
            1
        )->unfoldUsing(
            Type::isNumber()->unfoldUsing(1)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.12,
            66 // 2
        )->unfoldUsing(
            Type::isInteger()->unfoldUsing(1.0)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.17, // 0.11, // 0.1, // 0.09, // 0.08,
            66
        )->unfoldUsing(
            Type::isFloat()->unfoldUsing(1.0)
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
            0.72, // 0.71, // 0.56,
            94
        )->unfoldUsing(
            Type::isString()->unfoldUsing("")
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.04, // 0.02, // 0.006,
            1
        )->unfoldUsing(
            Type::isString()->unfoldUsing("8fold!")
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            1.41,
            1
        )->unfoldUsing(
            Type::isString()->unfoldUsing("{}")
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
            0.86, // 0.79, // 0.6,
            94
        )->unfoldUsing(
            Type::isCollection()->unfoldUsing([])
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.02, // 0.005, // 0.004,
            1
        )->unfoldUsing(
            Type::isList()->unfoldUsing([0, 1, 2])
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.88, // 0.78, // 0.77, // 0.72,
            39
        )->unfoldUsing(
            Type::isArray()->unfoldUsing([0, 1, 2])
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.05, // 0.04, // 0.02, // 0.01, // 0.009, // 0.008, // 0.008,
            1
        )->unfoldUsing(
            Type::isArray()
                ->unfoldUsing([3 => "8fold", 4 => true])
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.04, // 0.03, // 0.01,
            1
        )->unfoldUsing(
            Type::isArray()->unfoldUsing(["a" => 1, "b" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.04, // 0.004, // 0.003,
            1
        )->unfoldUsing(
            Type::isDictionary()->unfoldUsing(["a" => 1, 1 => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.03, // 0.003,
            1
        )->unfoldUsing(
            Type::isDictionary()->unfoldUsing(["a" => 1, "b" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.1,
            4
        )->unfoldUsing(
            Type::isCollection()->unfoldUsing(new stdClass)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.1,
            1
        )->unfoldUsing(
            Type::isTuple()->unfoldUsing(
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
            0.69, // 0.66, // 0.64, // 0.63,
            94
        )->unfoldUsing(
            Type::isObject()->unfoldUsing(
                new class {
                    public $public = "content";
                    private $private = "private";
                }
            )
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.09,
            4
        )->unfoldUsing(
            Type::isObject()->unfoldUsing(
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
