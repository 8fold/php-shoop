<?php

namespace Eightfold\Shoop\Tests\Filter\Unit;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use \stdClass;

use Eightfold\Shoop\Filter\TypeFilters\IsTuple;

/**
 * @group TypeChecking
 *
 * @group  IsTuple
 */
class TypeIsTupleTest extends TestCase
{
    /**
     * @test
     */
    public function valid()
    {
        $expected = true;

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.32, // 0.29,
            11
        )->unfoldUsing(
            IsTuple::apply()->unfoldUsing(new stdClass)
        );

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.02, // 0.01,
            1
        )->unfoldUsing(
            IsTuple::apply()->unfoldUsing(new class {
                public $hello = "world";
            })
        );

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.12, // 0.1,
            4
        )->unfoldUsing(
            IsTuple::apply()->unfoldUsing('{}')
        );
    }

    /**
     * @test
     */
    public function invalid()
    {
        $expected = false;

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.02, // 0.01,
            1
        )->unfoldUsing(
            IsTuple::apply()->unfoldUsing(1)
        );

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsTuple::apply()->unfoldUsing(1.0)
        );

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsTuple::apply()->unfoldUsing(1.1)
        );

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsTuple::apply()->unfoldUsing(true)
        );

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsTuple::apply()->unfoldUsing(false)
        );

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.11,
            4
        )->unfoldUsing(
            IsTuple::apply()->unfoldUsing("")
        );

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsTuple::apply()->unfoldUsing([])
        );

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.02, // 0.01,
            1
        )->unfoldUsing(
            IsTuple::apply()->unfoldUsing(new class {
                private $hello = "world";
            })
        );

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.04, // 0.02, // 0.01,
            1
        )->unfoldUsing(
            IsTuple::apply()->unfoldUsing(
                new class {
                    public function test(): void
                    {}
                }
            )
        );
    }
}
