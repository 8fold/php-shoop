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
    public function count(): ESInt;

    public function __toString();

// - Manipulate
    public function toggle(); // 7.4 : self;

    public function sort(); // 7.4 : self;

    public function shuffle(); // 7.4 : self;

    public function start(...$prefixes); // 7.4 : self;

    public function end(...$suffixes); // 7.4 : self;

// - Search
    public function contains($needle): ESBool;

    public function startsWith($needle): ESBool;

    public function doesNotStartWith($needle): ESBool;

    public function endsWith($needle): ESBool;

    public function doesNotEndWith($needle): ESBool;

// - Math language
    public function plus(...$args); // 7.4 : self;

    public function minus(...$args); // 7.4 : self;

    public function multiply($int); // 7.4 : self;

    public function divide($value = null);

    public function split($splitter, $splits = 2);

// - Comparison
    public function is($compare): ESBool;

    public function isNot($compare): ESBool;

    public function isEmpty(): ESBool;

    public function isGreaterThan($compare): ESBool;

    public function isGreaterThanOrEqual($compare): ESBool;

    public function isLessThan($compare): ESBool;

    public function isLessThanOrEqual($compare): ESBool;
}
