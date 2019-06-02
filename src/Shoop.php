<?php

namespace Eightfold\Shoop;

class Shoop
{
    static public function int($int): ESInt
    {
        return ESInt::wrap($int);
    }

    static public function string($string): ESString
    {
        return ESString::wrap($string);
    }

    static public function array(...$values): ESArray
    {
        return ESArray::wrap(...$values);
    }

    static public function range($min, $max, $includeLast = true): ESRange
    {
        return ESRange::wrap($min, $max, $includeLast);
    }

    static public function bool($bool): ESBool
    {
        return ESBool::wrap($bool);
    }


}
