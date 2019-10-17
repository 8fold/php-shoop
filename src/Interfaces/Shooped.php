<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\{
    ESArray,
    ESInt,
    ESBool,
    ESString,
    ESObject,
    ESDictionary
};

interface Shooped extends
    \Countable,
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

    /**
     * @deprecated
     */
    public function enumerate(): ESArray;

// - PHP single-method interfaces
    // Does not make sense on ESBool
    public function count(): ESInt;

    // Does not make sense on ESBool
    public function __toString();

// - Manipulate
    public function toggle($preserveMembers = true); // 7.4 : self;

    public function shuffle(); // 7.4 : self;

    // Does not make sense on ESBool, ESInt
    public function sort($caseSensitive = true); // 7.4 : self;

    // Does not make sense on ESBool
    public function start(...$prefixes); // 7.4 : self;

    // Does not make sense on ESBool
    public function end(...$suffixes); // 7.4 : self;

// - Search
    // Does not make sense on ESBool
    public function has($needle): ESBool;

    // Does not make sense on ESBool
    public function startsWith($needle): ESBool;

    // Does not make sense on ESBool
    public function doesNotStartWith($needle): ESBool;

    // Does not make sense on ESBool
    public function endsWith($needle): ESBool;

    // Does not make sense on ESBool
    public function doesNotEndWith($needle): ESBool;

// - Math language
    public function multiply($int); // 7.4 : self;

    // Does not make sense on ESBool
    public function plus(...$args); // 7.4 : self;

    // Does not make sense on ESBool
    public function minus(...$args); // 7.4 : self;

    // Does not make sense on ESBool
    public function divide($value = null);

    // Does not make sense on ESBool
    public function split($splitter = 1, $splits = 2);

// - Getters
    // Does not make sense on ESBool
    public function first();

// - Comparison
    public function is($compare): ESBool;

    public function isNot($compare): ESBool;

    public function isEmpty(): ESBool;

    public function isGreaterThan($compare): ESBool;

    public function isGreaterThanOrEqual($compare): ESBool;

    public function isLessThan($compare): ESBool;

    public function isLessThanOrEqual($compare): ESBool;
}
