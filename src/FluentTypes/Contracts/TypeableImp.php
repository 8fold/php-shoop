<?php

namespace Eightfold\Shoop\Contracts;

use Eightfold\Shoop\Php;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\ESArray;
use Eightfold\Shoop\ESBool;
use Eightfold\Shoop\ESDictionary;
use Eightfold\Shoop\ESInt;
use Eightfold\Shoop\ESJson;
use Eightfold\Shoop\ESObject;
use Eightfold\Shoop\ESString;

use Eightfold\Shoop\Php\AsArray;
use Eightfold\Shoop\Php\AsBool;
use Eightfold\Shoop\Php\AsDictionary;
use Eightfold\Shoop\Php\AsInt;
use Eightfold\Shoop\Php\AsJson;
use Eightfold\Shoop\Php\AsObject;
use Eightfold\Shoop\Php\AsString;

trait TypeableImp
{
    public function array(): ESArray
    {
        $array = Shoop::pipe($this->main, AsArray::apply());
        return ESArray::fold($array);
    }

    public function bool(): ESBool
    {
        $bool = Shoop::pipe($this->main, AsBool::apply());
        return ESBool::fold($bool);
    }

    public function dictionary(): ESDictionary
    {
        $array = Shoop::pipe($this->main, AsDictionary::apply());
        return ESDictionary::fold($array);
    }

    public function int(): ESInt
    {
        return ESInt::fold($this->count());
    }

    public function count(): int
    {
        return Shoop::pipe($this->main, AsInt::apply())->unfold();
    }

    public function json(): ESJson
    {
        $string = Shoop::pipe($this->main, AsJson::apply())->unfold();
        return ESJson::fold($string);
    }

    public function jsonSerialize(): object
    {
        $method = "{$this->getType()}ToObject";
        return Php::{$method}($this->main);
    }

    public function object(): ESObject
    {
        $object = Shoop::pipe($this->main, AsObject::apply())->unfold();
        // $method = "{$this->getType()}ToObject";
        // $object = Php::{$method}($this->main);
        return ESObject::fold($object);
    }

    public function string($arg = ""): ESString
    {
        $string = Shoop::pipe($this->main, AsString::applyWith($arg))->unfold();
        return ESString::fold($string);
    }
}
