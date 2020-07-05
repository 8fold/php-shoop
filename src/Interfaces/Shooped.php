<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\{
    ESArray,
    ESInt,
    ESBool,
    ESString,
    ESObject,
    ESDictionary,
    ESJson
};

interface Shooped extends
    \ArrayAccess,
    // ?? ObjectAccess = __unset, __isset, __get, __set
    \Iterator
    // Serializable ??
{
    static public function fold($args);

    public function unfold();

    public function value();

    public function condition($bool, \Closure $closure = null);

// - Type Juggling
    public function array(): ESArray;

    public function bool(): ESBool;

    public function dictionary(): ESDictionary;

    public function int(): ESInt;

    public function json(): ESJson;

    public function object(): ESObject;

    public function string(): ESString;

// - Comparison
    public function is($compare);

    public function isNot($compare);

    public function isEmpty(\Closure $closure = null);

    public function isNotEmpty(\Closure $closure = null);

// - Getters/Setters
    public function get($member = 0);

    public function getUnfolded($name);

    public function set($value, $member = null, $overwrite = true);

// - PHP interfaces and magic methods
    public function __call(string $name, array $args = []);

    public function __get($name);

    public function __toString(): string;

    public function __debugInfo();

// - Array Access
    public function offsetExists($offset): bool;

    public function offsetGet($offset);

    public function offsetSet($offset, $value): void;

    public function offsetUnset($offset): void;

// - Iterator
    public function rewind(): void;

    public function valid(): bool;

    public function current();

    public function key();

    public function next(): void;
}
