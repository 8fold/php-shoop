<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Interfaces\Shooped;

class Shoop
{
    static public function this($potential, string $shoopType = "")
    {
        return Type::sanitizeType($potential, $shoopType);
    }

    static public function array($array): ESArray
    {
        return static::this($array, ESArray::class);
    }

    static public function bool($bool): ESBool
    {
        return static::this($bool, ESBool::class);
    }

    static public function dictionary($assocArray): ESDictionary
    {
        return static::this($assocArray, ESDictionary::class);
    }

    static public function int($int): ESInt
    {
        return static::this($int, ESInt::class);
    }

    static public function json($json): ESJson
    {
        return static::this($json, ESJson::class);
    }

    static public function object($object): ESObject
    {
        return static::this($object, ESObject::class);
    }

    static public function string($string): ESString
    {
        return static::this($string, ESString::class);
    }

    static public function yaml($yaml): ESYaml
    {
        return static::this($yaml, ESYaml::class);
    }
}
