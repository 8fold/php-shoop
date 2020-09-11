<?php

namespace Eightfold\Shoop\Tests\Filter\Unit;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use \stdClass;

use Eightfold\Shoop\Filter\TypeFilters\IsString;

/**
 * @group TypeChecking
 *
 * @group  IsString
 */
class TypeIsStringTest extends TestCase
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
            0.45, // 0.44, // 0.36,
            22 // 14
        )->unfoldUsing(
            IsString::apply()->unfoldUsing("")
        );

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.02, // 0.01,
            1
        )->unfoldUsing(
            IsString::apply()->unfoldUsing("hello")
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
            0.01,
            1
        )->unfoldUsing(
            IsString::apply()->unfoldUsing(1)
        );

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsString::apply()->unfoldUsing(1.0)
        );

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsString::apply()->unfoldUsing(1.1)
        );

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.03, // 0.01,
            1
        )->unfoldUsing(
            IsString::apply()->unfoldUsing(true)
        );

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsString::apply()->unfoldUsing(false)
        );

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsString::apply()->unfoldUsing([])
        );

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsString::apply()->unfoldUsing(new stdClass)
        );

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsString::apply()->unfoldUsing(new class {
                public $hello = "world";
            })
        );

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.02,
            1
        )->unfoldUsing(
            IsString::apply()->unfoldUsing('{}')
        );

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsString::apply()->unfoldUsing(new class {
                private $hello = "world";
            })
        );

        AssertEquals::applyWith(
            $expected,
            "boolean",
            0.01,
            1
        )->unfoldUsing(
            IsString::apply()->unfoldUsing(
                new class {
                    public function test(): void
                    {}
                }
            )
        );
    }
}
