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

    public function string(): ESString;

    public function array(): ESArray;

    /**
     * @deprecated
     */
    public function enumerate(): ESArray;

    public function dictionary(): ESDictionary;

    public function object(): ESObject;

    public function int(): ESInt;

    public function bool(): ESBool;

// - PHP single-method interfaces
    public function count(): ESInt;

    public function __toString();

// - Defines what it means to be Shooped
    public function toggle(); // 7.4 : self;

    public function sort(); // 7.4 : self;

    public function shuffle(); // 7.4 : self;

    public function contains($needle): ESBool;

    public function start(...$prefixes); // 7.4 : self;

    public function startsWith($needle): ESBool;

    public function doesNotStartWith($needle): ESBool;

    public function end(...$suffixes); // 7.4 : self;

    public function plus(...$args); // 7.4 : self;

    public function multiply($int); // 7.4 : self;

    public function endsWith($needle): ESBool;

    public function doesNotEndWith($needle): ESBool;

    public function minus($value); // 7.4 : self;

    public function divide($value = null);

    public function split($splitter, $splits = 2): ESArray;

    public function isGreaterThan($compare): ESBool;

    public function isGreaterThanOrEqual($compare): ESBool;

    public function isLessThan($compare): ESBool;

    public function isLessThanOrEqual($compare): ESBool;

    public function is($compare): ESBool;

    public function isNot($compare): ESBool;
}
