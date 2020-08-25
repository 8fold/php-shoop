<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use \ArrayAccess;
use \Iterator;

interface Arrayable extends ArrayAccess, Iterator
{
    // PHP 8.0 - Arrayable|array
    public function asArray(
        $start = 0,
        bool $includeEmpties = true,
        int $limit = PHP_INT_MAX
    );

    public function efToArray(): array;

    public function has($needle);

    public function hasAt($member);

    public function at($member);

    // TODO: PHP 8.0 - mixed, string|int, bool|Falsifiable
    public function plusAt(
        $value,
        $member = PHP_INT_MAX,
        bool $overwrite = false
    );

    public function minusAt($member);

    public function offsetExists($offset): bool; // ArrayAccess

    public function offsetGet($offset); // ArrayAccess

    public function offsetSet($offset, $value): void; // ArrayAccess

    public function offsetUnset($offset): void; // ArrayAcces

// - Iterator
    public function rewind(): void;

    public function valid(): bool;

    public function current();

    public function key();

    public function next(): void;
}
