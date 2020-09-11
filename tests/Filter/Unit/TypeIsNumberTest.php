<?php

namespace Eightfold\Shoop\Tests\Filter\Unit;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use \stdClass;

use Eightfold\Shoop\Filter\TypeFilters\IsNumber;

/**
 * @group TypeChecking
 *
 * @group  IsNumber
 */
class TypeIsNumberTest extends TestCase
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
            IsNumber::apply()->unfoldUsing(1)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsNumber::apply()->unfoldUsing(1.0)
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
            0.02, // 0.01,
            1
        )->unfoldUsing(
            IsNumber::apply()->unfoldUsing(true)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsNumber::apply()->unfoldUsing(false)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsNumber::apply()->unfoldUsing("")
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsNumber::apply()->unfoldUsing([])
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsNumber::apply()->unfoldUsing(new stdClass)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsNumber::apply()->unfoldUsing('{}')
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsNumber::apply()->unfoldUsing(
                new class {
                    public function test(): void
                    {}
                }
            )
        );
    }
}
