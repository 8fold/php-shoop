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

use Eightfold\Shoop\Php\ToArray;
use Eightfold\Shoop\Php\ToBool;
use Eightfold\Shoop\Php\ToDictionary;
use Eightfold\Shoop\Php\ToInt;
use Eightfold\Shoop\Php\ToJson;
use Eightfold\Shoop\Php\ToObject;
use Eightfold\Shoop\Php\ToString;

trait TypeableImp
{
    public function array(): ESArray
    {
        $array = Shoop::pipeline($this->main, ToArray::bend());
        return ESArray::fold($array);
    }

    public function bool(): ESBool
    {
        $bool = Shoop::pipeline($this->main, ToBool::bend());
        return ESBool::fold($bool);
    }

    public function dictionary(): ESDictionary
    {
        $array = Shoop::pipeline($this->main, ToDictionary::bend());
        return ESDictionary::fold($array);
    }

    public function int(): ESInt
    {
        return ESInt::fold($this->count());
    }

    public function count(): int
    {
        return Shoop::pipeline($this->main, ToInt::bend())->unfold();
    }

    public function json(): ESJson
    {
        $string = Shoop::pipeline($this->main, ToJson::bend())->unfold();
        return ESJson::fold($string);
    }

    public function jsonSerialize(): object
    {
        $method = "{$this->getType()}ToObject";
        return Php::{$method}($this->main);
    }

    public function object(): ESObject
    {
        $object = Shoop::pipeline($this->main, ToObject::bend())->unfold();
        // $method = "{$this->getType()}ToObject";
        // $object = Php::{$method}($this->main);
        return ESObject::fold($object);
    }

    public function string($arg = ""): ESString
    {
        $string = Shoop::pipeline($this->main, ToString::bendWith($arg))->unfold();
        return ESString::fold($string);
    }
}
