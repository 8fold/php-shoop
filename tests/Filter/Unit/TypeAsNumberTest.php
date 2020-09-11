<?php

namespace Eightfold\Shoop\Tests\Filter\Unit;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use \stdClass;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Filter\TypeFilters\AsNumber;
use Eightfold\Shoop\FilterContracts\Interfaces\Countable;

/**
 * @group TypeChecking
 *
 * @group  AsNumber
 */
class TypeAsNumberTest extends TestCase
{
    /**
     * @test
     */
    public function boolean()
    {
        AssertEquals::applyWith(
            1,
            "integer",
            0.39, // 0.38, // 0.35, // 0.34, // 0.26,
            70 // 23 // 17
        )->unfoldUsing(
            AsNumber::fromBoolean(true)
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
            0.41, // 0.33,
            20
        )->unfoldUsing(
            AsNumber::fromNumber(1)
        );

        AssertEquals::applyWith(
            0,
            "integer",
            0.004,
            1
        )->unfoldUsing(
            AsNumber::fromNumber(0.0)
        );

        AssertEquals::applyWith(
            1.1,
            "double",
            0.002,
            1
        )->unfoldUsing(
            AsNumber::fromNumber(1.1)
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
            0.42, // 0.36, // 0.33,
            19
        )->unfoldUsing(
            AsNumber::fromString("")
        );

        AssertEquals::applyWith(
            8,
            "integer",
            0.003,
            1
        )->unfoldUsing(
            AsNumber::fromString("8fold!")
        );

        AssertEquals::applyWith(
            8.0,
            "double",
            0.002,
            1
        )->unfoldUsing(
            AsNumber::fromString("8fold.")
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
            0.57, // 0.41, // 0.4, // 0.39,
            22 // 21 // 20
        )->unfoldUsing(
            AsNumber::fromList([])
        );

        AssertEquals::applyWith(
            1,
            "integer",
            0.003,
            1
        )->unfoldUsing(
            AsNumber::fromList(["a" => 1, "b" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            0,
            "integer",
            0.5, // 0.41,
            81 // 25 // 18
        )->unfoldUsing(
            AsNumber::fromTuple(new stdClass)
        );

        AssertEquals::applyWith(
            1,
            "integer",
            0.02, // 0.01,
            1
        )->unfoldUsing(
            AsNumber::fromTuple(
                new class {
                    public $public = "content";
                    private $private = "private";
                }
            )
        );

        AssertEquals::applyWith(
            1,
            "integer",
            0.15,
            7
        )->unfoldUsing(
            AsNumber::fromJson('{"member":false}')
        );

        AssertEquals::applyWith(
            0,
            "integer",
            0.01,
            1
        )->unfoldUsing(
            AsNumber::fromTuple('{}')
        );

        AssertEquals::applyWith(
            1,
            "integer",
            0.01,
            1
        )->unfoldUsing(
            AsNumber::fromTuple('{"member":false}')
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
            0.92, // 0.74, // 0.69,
            81 // 40
        )->unfoldUsing(
            AsNumber::fromObject(
                new class {
                    public $public = "content";
                    private $private = "private";
                }
            )
        );

        AssertEquals::applyWith(
            0,
            "integer",
            0.01,
            1
        )->unfoldUsing(
            AsNumber::fromObject(
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
            1.86, // 1.56,
            126 // 85
        )->unfoldUsing(
            AsNumber::fromObject(
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
