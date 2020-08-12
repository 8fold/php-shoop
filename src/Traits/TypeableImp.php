<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Php;

use Eightfold\Shoop\ESArray;
use Eightfold\Shoop\ESBool;
use Eightfold\Shoop\ESDictionary;
use Eightfold\Shoop\ESJson;
use Eightfold\Shoop\ESObject;
use Eightfold\Shoop\ESString;

trait TypeableImp
{
    public function array(): ESArray
    {
        $type   = gettype($this->main);
        $method = "{$type}ToArray";
        $array  = Php::{$method}($this->main);
        return ESArray::fold($array);
    }

    public function bool(): ESBool
    {
        $type = gettype($this->main);
        $method = "{$type}ToBool";
        $bool = Php::{$method}($this->main);
        return ESBool::fold($bool);
    }

    public function dictionary(): ESDictionary
    {
        $type = gettype($this->main);
        $method = "{$type}ToDictionary";
        $array = Php::{$method}($this->main);
        return ESDictionary::fold($array);
    }

    public function int(): ESInt
    {
        return ESInt::fold($this->count());
    }

    public function count(): int
    {
        $type = gettype($this->main);
        $method = $type ."ToInt";
        return Php::{$method}($this->main);
    }

    public function json(): ESJson
    {
        $type   = gettype($this->main);
        $method = "{$type}ToJson";
        $object = Php::{$method}($this->main);
        return ESJson::fold($object);
    }

    public function object(): ESObject
    {
        $type   = gettype($this->main);
        $method = "{$type}ToObject";
        $object = Php::{$method}($this->main);
        return ESObject::fold($object);
    }

    public function jsonSerialize(): object
    {
        $type = gettype($this->main);
        $method = "{$type}ToObject";
        return Php::{$method}($this->main);
    }

    public function string($arg): ESString
    {
        $type   = gettype($this->main);
        $method = "{$type}ToString";
        $string = Php::{$method}($this->main, $arg);
        return ESString::fold($string);
    }
}
