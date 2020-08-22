<?php

namespace Eightfold\Shoop;

use Eightfold\Foldable\Pipe;
use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\FluentTypes\Interfaces\Shooped;

use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESBoolean;
use Eightfold\Shoop\FluentTypes\ESDictionary;
use Eightfold\Shoop\FluentTypes\ESInteger;
use Eightfold\Shoop\FluentTypes\ESJson;
use Eightfold\Shoop\FluentTypes\ESTuple;
use Eightfold\Shoop\FluentTypes\ESString;

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

    // TODO: PHP 8.0 bool|ESBoolean
    static public function bool($bool): ESBoolean
    {
        return static::this($bool, ESBoolean::class);
    }

    // TODO: PHP 8.0 dictionary|ESDictionary
    static public function dictionary($assocArray): ESDictionary
    {
        return static::this($assocArray, ESDictionary::class);
    }

    // TODO: PHP 8.0 int|ESInteger
    static public function int($int): ESInteger
    {
        return static::this($int, ESInteger::class);
    }

    // TODO: PHP 8.0 string|ESString
    static public function json($json): ESJson
    {
        return static::this($json, ESJson::class);
    }

    // TODO: PHP 8.0 object|ESTuple
    static public function object($object): ESTuple
    {
        return static::this($object, ESTuple::class);
    }

    // TODO: PHP 8.0 string|ESString
    static public function string($string): ESString
    {
        return static::this($string, ESString::class);
    }
}
