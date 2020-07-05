<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\Interfaces\ShoopedExtensions\{PhpInterfaces, PhpMagicMethods};

use Eightfold\Shoop\{
    ESArray,
    ESInt,
    ESBool,
    ESString,
    ESObject,
    ESDictionary,
    ESJson
};

interface Shooped extends PhpInterfaces, PhpMagicMethods
    // ?? ObjectAccess = __unset, __isset, __get, __set
    // Serializable ??
    // JsonSerializable
{
    static public function fold($args);

    public function unfold();

    public function value();

    // TODO: Consider a method called "if" - then deprecate
    public function condition($bool, \Closure $closure = null);

// - Type Juggling
    public function array(): ESArray;

    public function bool(): ESBool;

    public function dictionary(): ESDictionary;

    public function int(): ESInt;

    public function json(): ESJson;

    public function object(): ESObject;

    public function string(): ESString;
}
