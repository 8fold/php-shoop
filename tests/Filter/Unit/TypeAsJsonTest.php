<?php

namespace Eightfold\Shoop\Tests\Filter\Unit;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use \stdClass;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Filter\TypeFilters\AsJson;

use Eightfold\Shoop\Filter\TypeFilters\AsTuple;
use Eightfold\Shoop\FilterContracts\Interfaces\Tupleable;

/**
 * @group TypeChecking
 *
 * @group  AsJson
 */
class TypeAsJsonTest extends TestCase
{
    /**
     * @test
     */
    public function boolean()
    {
        AssertEquals::applyWith(
            '{"false":false,"true":true}',
            "string",
            0.82, // 0.76, // 0.62, // 0.6, // 0.53,
            45 // 40
        )->unfoldUsing(
            AsJson::fromBoolean(true)
        );

        AssertEquals::applyWith(
            '{"false":true,"true":false}',
            "string",
            0.01, // 0.004,
            1
        )->unfoldUsing(
            AsJson::fromBoolean(false)
        );
    }

    /**
     * @test
     */
    public function numbers()
    {
        AssertEquals::applyWith(
            '{"0.0":1}',
            "string",
            1.09,
            78
        )->unfoldUsing(
            AsJson::fromNumber(1)
        );

        AssertEquals::applyWith(
            '{"0.0":0}',
            "string",
            0.02, // 0.01,
            1
        )->unfoldUsing(
            AsJson::fromNumber(0.0)
        );

        AssertEquals::applyWith(
            '{"0.0":1.1}',
            "string",
            0.02, // 0.01, // 0.005, // 0.004,
            1
        )->unfoldUsing(
            AsJson::fromNumber(1.1)
        );
    }

    /**
     * @test
     */
    public function strings()
    {
        AssertEquals::applyWith(
            '{}',
            "string",
            0.89, // 0.83, // 0.72,
            53
        )->unfoldUsing(
            AsJson::fromString("")
        );

        AssertEquals::applyWith(
            '{"content":"8fold!"}',
            "string",
            0.02, // 0.01,
            1
        )->unfoldUsing(
            AsJson::fromString("8fold!")
        );
    }

    /**
     * @test
     */
    public function collections()
    {
        AssertEquals::applyWith(
            '{}',
            "string",
            0.51, // 0.5, // 0.43, // 0.42,
            20 // 19
        )->unfoldUsing(
            AsJson::fromList([])
        );

        AssertEquals::applyWith(
            '{"3":4,"5":6}',
            "string",
            0.01, // 0.005, // 0.004,
            1
        )->unfoldUsing(
            AsJson::fromList([3 => 4, 5 => 6])
        );

        AssertEquals::applyWith(
            '{"a":1,"b":2,"c":3}',
            "string",
            0.01, // 0.002,
            1
        )->unfoldUsing(
            AsJson::fromList(["a" => 1, "b" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            '{}',
            "string",
            0.35, // 0.32, // 0.28,
            28
        )->unfoldUsing(
            AsJson::fromTuple(new stdClass)
        );

        AssertEquals::applyWith(
            '{"public":"content"}',
            "string",
            0.02, // 0.01,
            1
        )->unfoldUsing(
            AsJson::fromTuple(
                new class {
                    public $public = "content";
                    private $private = "private";
                }
            )
        );

        AssertEquals::applyWith(
            '{"member":false}',
            "string",
            0.03, // 0.01,
            1
        )->unfoldUsing(
            AsJson::fromJson('{"member":false}')
        );

        AssertEquals::applyWith(
            '{}',
            "string",
            0.21, // 0.19, // 0.17,
            74
        )->unfoldUsing(
            AsJson::fromTuple('{}')
        );
    }

    /**
     * @test
     */
    public function objects()
    {
        AssertEquals::applyWith(
            '{"public":"content"}',
            "string",
            0.86, // 0.65,
            49
        )->unfoldUsing(
            AsJson::fromObject(
                new class {
                    public $public = "content";
                    private $private = "private";
                }
            )
        );

        AssertEquals::applyWith(
            '{"public":"content"}',
            "string",
            0.02, // 0.01,
            1
        )->unfoldUsing(
            AsJson::fromObject(
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
            '{"one":1,"two":2}',
            "string",
            1.33, // 1.24, // 1.02,
            124
        )->unfoldUsing(
            AsJson::fromObject(
                new class implements Tupleable {
                    public $public = "content";
                    private $private = "private";

                    public function asTuple(): Tupleable
                    {
                        $instance = new class {
                            public $one = 1;
                            public $two;

                            public function __construct($two = 2)
                            {
                                $this->two = 2;
                            }
                        };
                        $tuple = AsTuple::fromTuple($instance);
                        return Shoop::this($tuple);
                    }

                    public function efToTuple(): object
                    {
                        return $this->asTuple()->unfold();
                    }

                    public function asJson(): Tupleable
                    {
                        $tuple = $this->efToTuple();
                        $json = AsJson::fromTuple($tuple);
                        return Shoop::this($json);
                    }

                    public function efToJson(): string
                    {
                        return $this->asJson()->unfold();
                    }

                    public function jsonSerialize(): object
                    {
                        $json = $this->efToJson();
                        return AsTuple::fromJson($json);
                    }
                }
            )
        );
    }
}
