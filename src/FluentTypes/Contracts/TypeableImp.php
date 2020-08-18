<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use Eightfold\Shoop\PipeFilters;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESBool;
use Eightfold\Shoop\ESDictionary;
use Eightfold\Shoop\FluentTypes\ESInt;
use Eightfold\Shoop\ESJson;
use Eightfold\Shoop\ESObject;
use Eightfold\Shoop\FluentTypes\ESString;

use Eightfold\Shoop\PipeFilters\AsArray;
use Eightfold\Shoop\PipeFilters\AsBool;
use Eightfold\Shoop\PipeFilters\AsDictionary;
use Eightfold\Shoop\PipeFilters\AsInt;
use Eightfold\Shoop\PipeFilters\AsJson;
use Eightfold\Shoop\PipeFilters\AsObject;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsString;

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
        return Shoop::pipe($this->main, AsInteger::apply())->unfold();
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
