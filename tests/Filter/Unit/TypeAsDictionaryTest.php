<?php

namespace Eightfold\Shoop\Tests\Filter\Unit;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use \stdClass;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Filter\TypeFilters\AsDictionary;
use Eightfold\Shoop\FilterContracts\Interfaces\Addable;
use Eightfold\Shoop\FilterContracts\Interfaces\Subtractable;
use Eightfold\Shoop\FilterContracts\Interfaces\Associable;
use Eightfold\Shoop\FilterContracts\Interfaces\Falsifiable;

/**
 * @group TypeChecking
 *
 * @group  AsDictionary
 */
class TypeAsDictionaryTest extends TestCase
{
    /**
     * @test
     */
    public function boolean()
    {
        AssertEquals::applyWith(
            ["false" => false, "true" => true],
            "array",
            0.51, // 0.48, // 0.46, // 0.45,
            31 // 25
        )->unfoldUsing(
            AsDictionary::fromBoolean(true)
        );

        AssertEquals::applyWith(
            ["false" => true, "true" => false],
            "array",
            0.004, // 0.002,
            1
        )->unfoldUsing(
            AsDictionary::fromBoolean(false)
        );
    }

    /**
     * @test
     */
    public function numbers()
    {
        AssertEquals::applyWith(
            ["0.0" => 1],
            "array",
            0.68, // 0.65, // 0.64,
            49
        )->unfoldUsing(
            AsDictionary::fromNumber(1)
        );

        AssertEquals::applyWith(
            ["0.0" => 0.0],
            "array",
            0.04, // 0.02, // 0.01,
            1
        )->unfoldUsing(
            AsDictionary::fromNumber(0.0)
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
            0.63,
            35
        )->unfoldUsing(
            AsDictionary::fromString("")
        );

        AssertEquals::applyWith(
            ["content" => "8fold!"],
            "array",
            0.005, // 0.003,
            1
        )->unfoldUsing(
            AsDictionary::fromString("8fold!")
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
            1.23,
            62
        )->unfoldUsing(
            AsDictionary::fromList([])
        );

        AssertEquals::applyWith(
            ["3.0" => 4, "5.0" => 6],
            "array",
            0.18, // 0.11, // 0.1, // 0.09,
            2
        )->unfoldUsing(
            AsDictionary::fromList([3 => 4, 5 => 6])
        );

        AssertEquals::applyWith(
            ["a" => 1, "b" => 2, "c" => 3],
            "array",
            0.04, // 0.03, // 0.005,
            1
        )->unfoldUsing(
            AsDictionary::fromList(["a" => 1, "b" => 2, "c" => 3])
        );

        AssertEquals::applyWith(
            [],
            "array",
            0.1, // 0.09,
            4
        )->unfoldUsing(
            AsDictionary::fromTuple(new stdClass)
        );

        AssertEquals::applyWith(
            ["public" => "content"],
            "array",
            0.02, // 0.005,
            1
        )->unfoldUsing(
            AsDictionary::fromTuple(
                new class {
                    public $public = "content";
                    private $private = "private";
                }
            )
        );

        AssertEquals::applyWith(
            ["member" => false],
            "array",
            0.12, // 0.1,
            5
        )->unfoldUsing(
            AsDictionary::fromJson('{"member":false}')
        );

        AssertEquals::applyWith(
            [],
            "array",
            0.23, // 0.18,
            10
        )->unfoldUsing(
            AsDictionary::fromTuple('{}')
        );
    }

    /**
     * @test
     */
    public function objects()
    {
        AssertEquals::applyWith(
            ["public" => "content"],
            "array",
            0.62, // 0.5, // 0.49, // 0.47,
            36 // 35
        )->unfoldUsing(
            AsDictionary::fromObject(
                new class {
                    public $public = "content";
                    private $private = "private";
                }
            )
        );

        AssertEquals::applyWith(
            ["public" => "content"],
            "array",
            0.02, // 0.01,
            1
        )->unfoldUsing(
            AsDictionary::fromObject(
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
            ["associable" => true],
            "array",
            1.41, // 1.21, // 1.07,
            123
        )->unfoldUsing(
            AsDictionary::fromObject(
                new class implements Associable {
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
                        return Shoop::this(["associable" => true]);
                    }

                    public function efToDictionary(): array
                    {
                        return $this->asDictionary()->unfold();
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
