<?php

namespace Eightfold\Shoop\Tests\Filter\Unit;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use \stdClass;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Filter\TypeFilters\AsBoolean;
use Eightfold\Shoop\FilterContracts\Interfaces\Falsifiable;

/**
 * @group TypeChecking
 *
 * @group  AsBoolean
 */
class TypeAsBooleanTest extends TestCase
{
    /**
     * @test
     */
    public function boolean()
    {
        AssertEquals::applyWith(
            true,
            "boolean",
            0.87, // 0.72,
            69 // 25 // 24 // 20
        )->unfoldUsing(
            AsBoolean::fromBoolean(true)
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
            0.41, // 0.37, // 0.36, // 0.3, // 0.29,
            20
        )->unfoldUsing(
            AsBoolean::fromNumber(1)
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.004, // 0.002,
            1
        )->unfoldUsing(
            AsBoolean::fromNumber(0.0)
        );
    }

    /**
     * @test
     */
    public function strings()
    {
        AssertEquals::applyWith(
            false,
            "boolean",
            0.43,
            20
        )->unfoldUsing(
            AsBoolean::fromString("")
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.005, // 0.002,
            1
        )->unfoldUsing(
            AsBoolean::fromString("8fold!")
        );
    }

    /**
     * @test
     */
    public function collections()
    {
        AssertEquals::applyWith(
            false,
            "boolean",
            0.42, // 0.35, // 0.32,
            25 // 22 // 21
        )->unfoldUsing(
            AsBoolean::fromList([])
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.004, // 0.002,
            1
        )->unfoldUsing(
            AsBoolean::fromList([0, 1, 2])
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.004,
            1
        )->unfoldUsing(
            AsBoolean::fromList(["a" => 1, "b" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.32, // 0.23, // 0.22, // 0.09,
            10 // 8 // 4
        )->unfoldUsing(
            AsBoolean::fromTuple(new stdClass)
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.02, // 0.01, // 0.005, // 0.004,
            1
        )->unfoldUsing(
            AsBoolean::fromTuple(
                new class {
                    public $public = "content";
                    private $private = "private";
                }
            )
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.88,
            43
        )->unfoldUsing(
            AsBoolean::fromJson('{"member":false}')
        );

        AssertEquals::applyWith(
            false,
            "boolean",
            0.1, // 0.01,
            1
        )->unfoldUsing(
            AsBoolean::fromTuple('{}')
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.02,
            1
        )->unfoldUsing(
            AsBoolean::fromTuple('{"member":false}')
        );
    }

    /**
     * @test
     */
    public function objects()
    {
        AssertEquals::applyWith(
            true,
            "boolean",
            0.77, // 0.75, // 0.63, // 0.4, // 0.38, // 0.37,
            38 // 33 // 23
        )->unfoldUsing(
            AsBoolean::fromObject(
                new class {
                    public $public = "content";
                    private $private = "private";
                }
            )
        );

        AssertEquals::applyWith(
            true,
            "boolean",
            0.03, // 0.01,
            1
        )->unfoldUsing(
            AsBoolean::fromObject(
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

        AssertEquals::applyWith(
            true,
            "boolean",
            8.2,
            126 // 71
        )->unfoldUsing(
            AsBoolean::fromTuple(
                new class implements Falsifiable {
                    public $public = "content";
                    private $private = "private";
                    public function asBoolean(): Falsifiable
                    {
                        return Shoop::this(false);
                    }

                    public function efToBoolean(): bool
                    {
                        return $this->asBoolean()->unfold();
                    }
                }
            )
        );
    }
}
