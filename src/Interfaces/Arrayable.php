<?php

namespace Eightfold\Shoop\Interfaces;

use \ArrayAccess;
use \Iterator;
use \Closure;

use Eightfold\Shoop\ESArray;

interface Arrayable
{
    public function array(): ESArray;

    // TODO: Consider moving to has interface or member interface
    public function hasMember($member, Closure $closure = null);

    // TODO: Consider moving to get interface or member interface
    public function getMember($member);

    // public function setMember($member): self;

    // public function stripMember($member): self;

// - Array Access
    // TODO: PHP 8.0 string|int|ESString|ESInt $offset
    public function offsetExists($offset): bool;

    // TODO: PHP 8.0 string|int|ESString|ESInt $offset
    public function offsetGet($offset);

    // public function offsetSet($offset, $value): void;

    // public function offsetUnset($offset): void;

// - Iterator
    // public function rewind(): void;

    // public function valid(): bool;

    // public function current();

    // public function key();

    // public function next(): void;
}
