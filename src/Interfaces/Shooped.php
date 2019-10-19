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
}
