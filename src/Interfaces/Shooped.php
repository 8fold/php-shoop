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
    public function __construct($initial);

    static public function fold($args);

    public function unfold();

// - Type Juggling
    public function string(): ESString;

    public function array(): ESArray;

    public function dictionary(): ESDictionary;

    public function object(): ESObject;

    public function int(): ESInt;

    public function bool(): ESBool;

    // Does not make sense for ESInt
    public function json(): ESJson;

// - PHP single-method interfaces
// - Math language
    public function multiply($int);

// - Comparison
    public function is($compare): ESBool;

    public function isNot($compare): ESBool;

    public function isEmpty(): ESBool;

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
