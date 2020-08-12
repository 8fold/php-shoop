<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Php;

use Eightfold\Shoop\ESArray;
use Eightfold\Shoop\ESBool;
use Eightfold\Shoop\ESString;

trait TypeableImp
{
    public function array(): ESArray
    {
        $type = gettype($this->main);
        $method = "{$type}ToArray";
        $array = Php::{$method}($this->main);
        return ESArray::fold($array);
    }

    public function string(): ESString
    {
        $type = gettype($this->main);
        $method = "{$type}ToString";
        $string = Php::{$method}($this->main);
        return ESString::fold($string);
    }
}
