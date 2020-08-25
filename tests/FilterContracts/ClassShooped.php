<?php

namespace Eightfold\Shoop\Tests\FilterContracts;

use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\FilterContracts\Shooped;

use Eightfold\Shoop\FilterContracts\Arrayable;
use Eightfold\Shoop\FilterContracts\Associable;
use Eightfold\Shoop\FilterContracts\Comparable;
use Eightfold\Shoop\FilterContracts\Countable;
use Eightfold\Shoop\FilterContracts\Falsifiable;
use Eightfold\Shoop\FilterContracts\Reversible;
use Eightfold\Shoop\FilterContracts\Stringable;
use Eightfold\Shoop\FilterContracts\Tupleable;

class ClassShooped implements Shooped
{
    static public function fold(...$args): Foldable
    {
    }

    public function __construct($main)
    {
    }

    public function unfold()
    {
    }

// - Arrayable
    public function asArray(
        $start = 0, // int|string
        bool $includeEmpties = true,
        int $limit = PHP_INT_MAX
    ): Arrayable
    {}

    public function efToArray(): array
    {}

// - Associable
    public function asDictionary(): Associable
    {}

    public function efToDictionary(): array
    {}

    public function has($needle)
    {
        # code...
    }

    public function hasAt($member)
    {
        # code...
    }

    public function at($member)
    {
        # code...
    }

    public function plusAt(
        $value, // mixed
        $member = PHP_INT_MAX, // int|string
        bool $overwrite = false
    ): Associable
    {
        # code...
    }

    public function minusAt($member)
    {
        # code...
    }

    public function offsetExists($offset): bool // ArrayAccess
    {

    }

    public function offsetGet($offset) // ArrayAccess
    {}

    public function offsetSet($offset, $value): void // ArrayAccess
    {}

    public function offsetUnset($offset): void // ArrayAcces
    {}

    public function rewind(): void // Iterator
    {}

    public function valid(): bool // Iterator
    {}

    public function current() // Iterator
    {}

    public function key() // Iterator
    {}

    public function next(): void // Iterator
    {}

// - Comparable
    public function is($compare): Comparable
    {}

    public function isEmpty(): Comparable
    {}

    public function isGreaterThan($compare): Comparable
    {}

    public function isGreaterThanOrEqualTo($compare): Comparable
    {}

    public function efIs($compare): bool
    {}

    public function efIsEmpty(): bool
    {}

    public function efIsGreaterThan($compare): bool
    {}

    public function efIsGreaterThanOrEqualTo($compare): bool
    {}

// - Countable
    public function asInteger(): Countable
    {}

    public function efToInteger(): int
    {}

    public function count(): int // Countable
    {}

// - Falsifiable
    public function asBoolean(): Falsifiable
    {}

    public function efToBoolean(): bool
    {}

// - Reversible
    public function reverse(): Reversible
    {}

// - Stringable
    public function asString(string $glue = ""): Stringable
    {}

    public function efToString(string $glue = ""): string
    {}

    public function __toString(): string
    {}

// - Tupleable
    public function asTuple(): Tupleable
    {}

    // PHP 8.0 - stdClass|object
    public function efToTuple(): object
    {}

    public function asJson(): Tupleable
    {}

    public function efToJson(): string
    {}

    public function jsonSerialize(): object // JsonSerializable
    {}

// - Typeable
    public function types(): array
    {}
}
