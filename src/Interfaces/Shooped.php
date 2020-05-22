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

// - Type Juggling
    public function string(): ESString;

    public function array(): ESArray;

    public function dictionary(): ESDictionary;

    public function object(): ESObject;

    public function int(): ESInt;

    public function bool(): ESBool;

    public function json(): ESJson;

// - Comparison
    public function is($compare): ESBool;

    public function isNot($compare): ESBool;

    public function isEmpty(): ESBool;

    public function isNotEmpty(): ESBool;

// - Getters/Setters
    public function get($member = 0);

    public function set($value, $member = null, $overwrite = true);

// - PHP single-method interfaces
    public function __call($name, $args = []);

    public function __get($name);

    public function __toString();

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
