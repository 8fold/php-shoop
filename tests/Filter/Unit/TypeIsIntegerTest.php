<?php

namespace Eightfold\Shoop\Tests\Filter\Unit;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use \stdClass;

use Eightfold\Shoop\Filter\TypeFilters\IsInteger;

/**
 * @group TypeChecking
 *
 * @group  IsInteger
 */
class TypeIsIntegerTest extends TestCase
{
    /**
     * @test
     */
    public function valid()
    {
        AssertEquals::applyWith(
            true,
            "boolean",
            0.38,
            9
        )->unfoldUsing(
            IsInteger::apply()->unfoldUsing(1)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.02, // 0.01,
            1
        )->unfoldUsing(
            IsInteger::apply()->unfoldUsing(1.0)
        );
    }

    /**
     * @test
     */
    public function invalid()
    {
        AssertEquals::applyWith(
            false,
            "boolean",
            0.04, // 0.02, // 0.01,
            1
        )->unfoldUsing(
            IsInteger::apply()->unfoldUsing(1.1)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.03, // 0.01,
            1
        )->unfoldUsing(
            IsInteger::apply()->unfoldUsing(true)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsInteger::apply()->unfoldUsing(false)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsInteger::apply()->unfoldUsing("")
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsInteger::apply()->unfoldUsing([])
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.03,
            1
        )->unfoldUsing(
            IsInteger::apply()->unfoldUsing(new stdClass)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.04, // 0.03,
            1
        )->unfoldUsing(
            IsInteger::apply()->unfoldUsing(new class {
                public $hello = "world";
            })
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsInteger::apply()->unfoldUsing('{}')
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsInteger::apply()->unfoldUsing(new class {
                private $hello = "world";
            })
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsInteger::apply()->unfoldUsing(
                new class {
                    public function test(): void
                    {}
                }
            )
        );
    }
}
