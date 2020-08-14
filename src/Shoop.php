<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Foldable\Pipe;

use Eightfold\Shoop\Interfaces\Foldable;
use Eightfold\Shoop\Interfaces\Shooped;

class Shoop
{
    static public function pipe($using, callable ...$elbows): Pipe
    {
        return Pipe::fold($using, ...$elbows);
    }

    static public function this($potential, string $shoopType = ""): Foldable
    {
        return Type::sanitizeType($potential, $shoopType);
    }

    // TODO: PHP 8.0 array|ESArray
    static public function array($array): ESArray
    {
        return static::this($array, ESArray::class);
    }

    // TODO: PHP 8.0 bool|ESBool
    static public function bool($bool): ESBool
    {
        return static::this($bool, ESBool::class);
    }

    // TODO: PHP 8.0 dictionary|ESDictionary
    static public function dictionary($assocArray): ESDictionary
    {
        return static::this($assocArray, ESDictionary::class);
    }

    // TODO: PHP 8.0 int|ESInt
    static public function int($int): ESInt
    {
        return static::this($int, ESInt::class);
    }

    // TODO: PHP 8.0 string|ESString
    static public function json($json): ESJson
    {
        return static::this($json, ESJson::class);
    }

    // TODO: PHP 8.0 object|ESObject
    static public function object($object): ESObject
    {
        return static::this($object, ESObject::class);
    }

    // TODO: PHP 8.0 string|ESString
    static public function string($string): ESString
    {
        return static::this($string, ESString::class);
    }
}
