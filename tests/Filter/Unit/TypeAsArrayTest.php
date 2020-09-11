<?php

namespace Eightfold\Shoop\Tests\Filter\Unit;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use \stdClass;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Filter\TypeFilters\AsArray;
use Eightfold\Shoop\FilterContracts\Interfaces\Addable;
use Eightfold\Shoop\FilterContracts\Interfaces\Subtractable;
use Eightfold\Shoop\FilterContracts\Interfaces\Arrayable;
use Eightfold\Shoop\FilterContracts\Interfaces\Associable;
use Eightfold\Shoop\FilterContracts\Interfaces\Falsifiable;

/**
 * @group TypeChecking
 *
 * @group  AsArray
 */
class TypeAsArrayTest extends TestCase
{
    /**
     * @test
     */
    public function boolean()
    {
        AssertEquals::applyWith(
            [false, true],
            "array",
            0.73, // 0.65, // 0.62, // 0.34,
            53 // 30 // 26
        )->unfoldUsing(
            AsArray::fromBoolean(true)
        );

        AssertEquals::applyWith(
            [true, false],
            "array",
            0.03, // 0.003, // 0.002,
            1
        )->unfoldUsing(
            AsArray::fromBoolean(false)
        );
    }

    /**
     * @test
     */
    public function numbers()
    {
        AssertEquals::applyWith(
            [1],
            "array",
            0.46, // 0.34,
            26
        )->unfoldUsing(
            AsArray::fromNumber(1)
        );

        AssertEquals::applyWith(
            [0.0],
            "array",
            0.004, // 0.002,
            1
        )->unfoldUsing(
            AsArray::fromNumber(0.0)
        );

        AssertEquals::applyWith(
            [1.1],
            "array",
            0.004,
            1
        )->unfoldUsing(
            AsArray::fromNumber(1.1)
        );

        AssertEquals::applyWith(
            [1.5],
            "array",
            0.001,
            1
        )->unfoldUsing(
            AsArray::fromNumber(1.5)
        );
    }

    /**
     * @test
     */
    public function strings()
    {
        AssertEquals::applyWith(
            [],
            "array",
            0.62, // 0.53,
            33
        )->unfoldUsing(
            AsArray::fromString("")
        );

        AssertEquals::applyWith(
            ["8", "f", "o", "l", "d", "!"],
            "array",
            0.03, // 0.01, // 0.003,
            1
        )->unfoldUsing(
            AsArray::fromString("8fold!")
        );
    }

    /**
     * @test
     */
    public function collections()
    {
        AssertEquals::applyWith(
            [],
            "array",
            0.55, // 0.53, // 0.52, // 0.49, // 0.44,
            31 // 30 // 29 // 27
        )->unfoldUsing(
            AsArray::fromList([])
        );

        AssertEquals::applyWith(
            [4, 6],
            "array",
            0.005, // 0.003, // 0.002,
            1
        )->unfoldUsing(
            AsArray::fromList([3 => 4, 5 => 6])
        );

        AssertEquals::applyWith(
            [1, 2, 3],
            "array",
            0.004, // 0.003,
            1
        )->unfoldUsing(
            AsArray::fromList(["a" => 1, "b" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            [],
            "array",
            0.49, // 0.47, // 0.46, // 0.42, // 0.33, // 0.28, // 0.27, // 0.22,
            28 // 27 // 26 // 14 // 10
        )->unfoldUsing(
            AsArray::fromTuple(new stdClass)
        );

        AssertEquals::applyWith(
            ["content"],
            "array",
            0.03, // 0.02, // 0.01, // 0.005, // 0.004,
            1
        )->unfoldUsing(
            AsArray::fromTuple(
                new class {
                    public $public = "content";
                    private $private = "private";
                }
            )
        );

        AssertEquals::applyWith(
            [false],
            "array",
            0.54, // 0.31, // 0.21,
            10
        )->unfoldUsing(
            AsArray::fromJson('{"member":false}')
        );

        AssertEquals::applyWith(
            [],
            "array",
            0.83, // 0.8,
            67 // 64
        )->unfoldUsing(
            AsArray::fromTuple('{}')
        );
    }

    /**
     * @test
     */
    public function objects()
    {
        AssertEquals::applyWith(
            ["content"],
            "array",
            1.03, // 0.77,
            64 // 63
        )->unfoldUsing(
            AsArray::fromObject(
                new class {
                    public $public = "content";
                    private $private = "private";
                }
            )
        );

        AssertEquals::applyWith(
            ["content"],
            "array",
            0.02, // 0.01, // 0.005,
            1
        )->unfoldUsing(
            AsArray::fromObject(
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
            [],
            "array",
            1.47, // 1.35,
            127 // 60
        )->unfoldUsing(
            AsArray::fromObject(
                new class implements Arrayable {
                    public $public = "content";
                    private $private = "private";

                    public function plus($value): Addable
                    {
                        return Shoop::this([]);
                    }

                    public function minus($value): Subtractable
                    {
                        return Shoop::this([]);
                    }

                    public function asDictionary(): Associable
                    {
                        return Shoop::this([]);
                    }

                    public function efToDictionary(): array
                    {
                        return $this->asDictionary()->unfold();
                    }

                    public function asArray(): Arrayable
                    {
                        return Shoop::this([]);
                    }

                    public function efToArray(): array
                    {
                        return $this->asArray()->unfold();
                    }

                    public function has($member): Falsifiable
                    {
                        return Shoop::this(true);
                    }

                    public function hasAt($member): Falsifiable
                    {
                        return Shoop::this(false);
                    }

                    public function offsetExists($offset): bool
                    {
                        return $this->hasAt($offset)->unfold();
                    }

                    public function at($member)
                    {
                        return false;
                    }

                    public function offsetGet($offset)
                    {
                        return $this->at($offset)->unfold();
                    }

                    public function plusAt($value, $member): Associable
                    {
                        $this->main[$member] = $value;
                        return $this;
                    }

                    public function offsetSet($offset, $value): void
                    {
                        $this->plusAt($value, $offset);
                    }

                    public function minusAt($member): Associable
                    {
                        unset($this->main[$member]);
                        return $this;
                    }

                    public function offsetUnset($offset): void
                    {
                        $this->minusAt($offset);
                    }

                    public function rewind(): void
                    {
                        rewind($this->main);
                    }

                    public function valid(): bool
                    {
                        $member = key($this->main);
                        return array_key_exists($member, $this->main);
                    }

                    public function current()
                    {
                        $member = key($temp);
                        return $temp[$member];
                    }

                    public function key()
                    {
                        key($this->main);
                    }

                    public function next(): void
                    {
                        next($this->main);
                    }
                }
            )
        );
    }
}
