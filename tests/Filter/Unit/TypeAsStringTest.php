<?php

namespace Eightfold\Shoop\Tests\Filter\Unit;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use \stdClass;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Filter\TypeFilters\AsString;
use Eightfold\Shoop\FilterContracts\Interfaces\Stringable;

/**
 * @group TypeChecking
 *
 * @group  AsString
 */
class TypeAsStringTest extends TestCase
{
    /**
     * @test
     */
    public function boolean()
    {
        AssertEquals::applyWith(
            "true",
            "string",
            0.42, // 0.41, // 0.3,
            23 // 18
        )->unfoldUsing(
            AsString::fromBoolean(true)
        );

        AssertEquals::applyWith(
            "false",
            "string",
            0.002,
            1
        )->unfoldUsing(
            AsString::fromBoolean(false)
        );
    }

    /**
     * @test
     */
    public function numbers()
    {
        AssertEquals::applyWith(
            "1.0",
            "string",
            0.41,
            20
        )->unfoldUsing(
            AsString::fromNumber(1)
        );

        AssertEquals::applyWith(
            "0.0",
            "string",
            0.004,
            1
        )->unfoldUsing(
            AsString::fromNumber(0.0)
        );

        AssertEquals::applyWith(
            "1.1",
            "string",
            0.43,
            1
        )->unfoldUsing(
            AsString::fromNumber(1.1)
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
            0.36, // 0.35, // 0.33,
            20
        )->unfoldUsing(
            AsString::fromString("")
        );

        AssertEquals::applyWith(
            "8fold!",
            "string",
            0.4,
            1
        )->unfoldUsing(
            AsString::fromString("8fold!")
        );
    }

    /**
     * @test
     */
    public function collections()
    {
        AssertEquals::applyWith(
            "",
            "string",
            0.58, // 0.55, // 0.52, // 0.46,
            27 // 26 // 25
        )->unfoldUsing(
            AsString::fromList([])
        );

        AssertEquals::applyWith(
            "",
            "string",
            0.004,
            1
        )->unfoldUsing(
            AsString::fromList([3 => 4, 5 => 6])
        );

        AssertEquals::applyWith(
            "a, b, c",
            "string",
            0.003, // 0.002,
            1
        )->unfoldUsing(
            AsString::fromList(["a", "b", "c"], ", ")
        );

        AssertEquals::applyWith(
            "",
            "string",
            0.43, // 0.39, // 0.36, // 0.34, // 0.33, // 0.3,
            27
        )->unfoldUsing(
            AsString::fromTuple(new stdClass)
        );

        AssertEquals::applyWith(
            "content",
            "string",
            0.34,
            1
        )->unfoldUsing(
            AsString::fromTuple(
                new class {
                    public $public = "content";
                    private $private = "private";
                }
            )
        );

        AssertEquals::applyWith(
            "",
            "string",
            0.13,
            5
        )->unfoldUsing(
            AsString::fromJson('{"member":false}')
        );

        AssertEquals::applyWith(
            "hello",
            "string",
            0.21,
            10
        )->unfoldUsing(
            AsString::fromTuple('{"member":"hello"}')
        );
    }

    /**
     * @test
     */
    public function objects()
    {
        AssertEquals::applyWith(
            "content",
            "string",
            1.03,
            55
        )->unfoldUsing(
            AsString::fromObject(
                new class {
                    public $public = "content";
                    private $private = "private";
                }
            )
        );

        AssertEquals::applyWith(
            "content",
            "string",
            0.01,
            1
        )->unfoldUsing(
            AsString::fromObject(
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
            "hello",
            "string",
            1.32,
            124
        )->unfoldUsing(
            AsString::fromObject(
                new class implements Stringable {
                    public $public = "content";
                    private $private = "private";

                    public function asString(string $glue = ""): Stringable
                    {
                        return Shoop::this("hello");
                    }

                    public function efToString(string $glue = ""): string
                    {
                        return $this->asString($glue)->unfold();
                    }

                    public function __toString(): string
                    {
                        return $this->efToString();
                    }
                }
            )
        );
    }
}
