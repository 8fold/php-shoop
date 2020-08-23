<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use \ArrayAccess;
use \Iterator;

interface Arrayable extends ArrayAccess, Iterator
{
    public function array(): Arrayable;

    // TODO: PHP 8.0 string|int|ESString|ESInteger $offset
    public function hasMember($member);

    public function offsetExists($offset): bool; // ArrayAccess

    public function at($member);

    public function offsetGet($offset); // ArrayAccess

    public function plusMember($value, $member);

    public function offsetSet($offset, $value): void; // ArrayAccess

    public function minusMember($member);

    public function offsetUnset($offset): void; // ArrayAcces

// - Iterator
    public function rewind(): void;

    public function valid(): bool;

    public function current();

    public function key();

    public function next(): void;

    /**
     * @deprecated
     */
    public function getMember($member, callable $callable = null);

    /**
     * @deprecated
     */
    public function setMember($member, $value);

    /**
     * @deprecated
     */
    public function stripMember($member);
}
