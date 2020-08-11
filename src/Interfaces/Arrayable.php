<?php

namespace Eightfold\Shoop\Interfaces;

use \ArrayAccess;
use \Iterator;
use \Closure;

use Eightfold\Shoop\ESArray;

interface Arrayable
{
    public function array(): ESArray;

    // TODO: PHP 8.0 string|int|ESString|ESInt $offset
    public function hasMember($member, callable $callable = null);

    public function offsetExists($offset): bool; // ArrayAccess

    public function getMember($member, callable $callable = null);

    public function offsetGet($offset); // ArrayAccess

    public function setMember($member, $value);

    public function offsetSet($offset, $value): void; // ArrayAccess

    public function stripMember($member);

    public function offsetUnset($offset): void; // ArrayAcces

// - Iterator
    public function rewind(): void;

    public function valid(): bool;

    public function current();

    public function key();

    public function next(): void;
}
