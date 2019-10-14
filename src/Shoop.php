<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Interfaces\Shooped;

class Shoop
{
    // TODO: create universal single entry point
    // Shoop::this($whatever)
    // static public function this($potential)
    // {
    //     return Type::sanitizeType($potential);
    // }

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

    static public function object($object): ESObject
    {
        return ESObject::fold($object);
    }

    static public function bool($bool): ESBool
    {
        return ESBool::fold($bool);
    }
}
