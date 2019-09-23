<?php

namespace Eightfold\Shoop;

class Shoop
{
    static public function int($int): ESInt
    {
        return ESInt::fold($int);
    }

    static public function string($string): ESString
    {
        return ESString::fold($string);
    }

    static public function array($array): ESArray
    {
        return ESArray::fold($array);
    }

    static public function dictionary($assocArray)
    {
        return ESDictionary::fold($assocArray);
    }

    static public function range($min, $max, $includeLast = true): ESRange
    {
        return ESRange::fold($min, $max, $includeLast);
    }

    static public function bool($bool): ESBool
    {
        return ESBool::fold($bool);
    }
}
