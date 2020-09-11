<?php

namespace Eightfold\Shoop\Tests\Filter\Unit;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use \stdClass;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Filter\TypeFilters\AsInteger;
use Eightfold\Shoop\FilterContracts\Interfaces\Countable;

/**
 * @group TypeChecking
 *
 * @group  AsInteger
 */
class TypeAsIntegerTest extends TestCase
{
    /**
     * @test
     */
    public function boolean()
    {
        AssertEquals::applyWith(
            1,
            "integer",
            0.39, // 0.36, // 0.3, // 0.29,
            14
        )->unfoldUsing(
            AsInteger::fromBoolean(true)
        );
    }

    /**
     * @test
     */
    public function numbers()
    {
        AssertEquals::applyWith(
            1,
            "integer",
            0.4, // 0.38, // 0.31,
            14
        )->unfoldUsing(
            AsInteger::fromNumber(1)
        );

        AssertEquals::applyWith(
            0,
            "integer",
            0.003,
            1
        )->unfoldUsing(
            AsInteger::fromNumber(0.0)
        );

        AssertEquals::applyWith(
            1,
            "integer",
            0.001,
            1
        )->unfoldUsing(
            AsInteger::fromNumber(1.1)
        );

        AssertEquals::applyWith(
            2,
            "integer",
            0.03, // 0.001,
            1
        )->unfoldUsing(
            AsInteger::fromNumber(1.5)
        );
    }

    /**
     * @test
     */
    public function strings()
    {
        AssertEquals::applyWith(
            0,
            "integer",
            0.43, // 0.35, // 0.3,
            14
        )->unfoldUsing(
            AsInteger::fromString("")
        );

        AssertEquals::applyWith(
            8,
            "integer",
            0.002,
            1
        )->unfoldUsing(
            AsInteger::fromString("8fold!")
        );

        AssertEquals::applyWith(
            8,
            "integer",
            0.001,
            1
        )->unfoldUsing(
            AsInteger::fromString("8fold.")
        );
    }

    /**
     * @test
     */
    public function collections()
    {
        AssertEquals::applyWith(
            0,
            "integer",
            0.46, // 0.35,
            14
        )->unfoldUsing(
            AsInteger::fromList([])
        );

        AssertEquals::applyWith(
            1,
            "integer",
            0.002,
            1
        )->unfoldUsing(
            AsInteger::fromList(["a" => 1, "b" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            0,
            "integer",
            0.43, // 0.41, // 0.39, // 0.35,
            17
        )->unfoldUsing(
            AsInteger::fromTuple(new stdClass)
        );

        AssertEquals::applyWith(
            1,
            "integer",
            0.02, // 0.01,
            1
        )->unfoldUsing(
            AsInteger::fromTuple(
                new class {
                    public $public = "content";
                    private $private = "private";
                }
            )
        );

        AssertEquals::applyWith(
            1,
            "integer",
            0.14,
            7
        )->unfoldUsing(
            AsInteger::fromJson('{"member":false}')
        );

        AssertEquals::applyWith(
            0,
            "integer",
            0.02, // 0.01,
            1
        )->unfoldUsing(
            AsInteger::fromTuple('{}')
        );

        AssertEquals::applyWith(
            1,
            "integer",
            0.01,
            1
        )->unfoldUsing(
            AsInteger::fromTuple('{"member":false}')
        );
    }

    /**
     * @test
     */
    public function objects()
    {
        AssertEquals::applyWith(
            1,
            "integer",
            0.73, // 0.72, // 0.6,
            88 // 32
        )->unfoldUsing(
            AsInteger::fromObject(
                new class {
                    public $public = "content";
                    private $private = "private";
                }
            )
        );

        AssertEquals::applyWith(
            0,
            "integer",
            0.02, // 0.01, // 0.005,
            1
        )->unfoldUsing(
            AsInteger::fromObject(
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
            10,
            "integer",
            1.26, // 1.13,
            231 // 62
        )->unfoldUsing(
            AsInteger::fromObject(
                new class implements Countable {
                    public $public = "content";
                    private $private = "private";
                    public function asInteger(): Countable
                    {
                        return Shoop::this(10);
                    }

                    public function efToInteger(): int
                    {
                        return $this->asInteger()->unfold();
                    }

                    public function count(): int
                    {
                        return $this->efToInteger();
                    }
                }
            )
        );
    }
}
