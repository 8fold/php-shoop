<?php

namespace Eightfold\Shoop\FilterContracts;

use \ArrayAccess;
use \Iterator;

interface Associable
{
    public function asDictionary(): Associable;

    public function efToDictionary(): array;

    public function has($member);

    public function hasAt($member);

    public function at($member);

    // TODO: PHP 8.0 - mixed, string|int, bool|Falsifiable
    public function plusAt(
        $value,
        $member = PHP_INT_MAX,
        bool $overwrite = false
    ): Associable;

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
