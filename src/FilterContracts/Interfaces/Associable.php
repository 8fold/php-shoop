<?php

namespace Eightfold\Shoop\FilterContracts\Interfaces;

use \ArrayAccess;
use \Iterator;

use Eightfold\Shoop\FilterContracts\Interfaces\Addable;
use Eightfold\Shoop\FilterContracts\Interfaces\Subtractable;

interface Associable extends ArrayAccess, Iterator, Addable, Subtractable
{
    public function asDictionary(): Associable;

    public function efToDictionary(): array;

    public function has($member);

    public function hasAt($member);

    public function offsetExists($offset): bool; // ArrayAccess

    public function at($member);

    public function offsetGet($offset); // ArrayAccess

    // TODO: PHP 8.0 - mixed, string|int, bool|Falsifiable
    public function plusAt(
        $value,
        $member = PHP_INT_MAX,
        bool $overwrite = false
    ): Associable;

    public function offsetSet($offset, $value): void; // ArrayAccess

    public function minusAt($member);

    public function offsetUnset($offset): void; // ArrayAcces

// - Iterator
    public function rewind(): void;

    public function valid(): bool;

    public function current();

    public function key();

    public function next(): void;
}
