<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Php;

use Eightfold\Shoop\ESArray;
use Eightfold\Shoop\ESBool;
use Eightfold\Shoop\ESDictionary;
use Eightfold\Shoop\ESInt;
use Eightfold\Shoop\ESJson;
use Eightfold\Shoop\ESObject;
use Eightfold\Shoop\ESString;

trait TypeableImp
{
    public function getType(): string
    {
        if (is_a($this, ESDictionary::class) and
            Php::arrayIsDictionary($this->main)
        )
        {
            return "dictionary";

        } elseif (is_a($this, ESJson::class) and
            Php::stringIsJson($this->main)
        )
        {
            return "json";
        }
            die(var_dump(Php::stringIsJson($this->main)));
        return gettype($this->main);
    }

    public function array(): ESArray
    {
        $method = "{$this->getType()}ToArray";
        $array  = Php::{$method}($this->main);
        return ESArray::fold($array);
    }

    public function bool(): ESBool
    {
        $method = "{$this->getType()}ToBool";
        $bool = Php::{$method}($this->main);
        return ESBool::fold($bool);
    }

    public function dictionary(): ESDictionary
    {
        $method = "{$this->getType()}ToDictionary";
        $array = Php::{$method}($this->main);
        return ESDictionary::fold($array);
    }

    public function int(): ESInt
    {
        return ESInt::fold($this->count());
    }

    public function count(): int
    {
        $method = "{$this->getType()}ToInt";
        return Php::{$method}($this->main);
    }

    public function json(): ESJson
    {
        $method = "{$this->getType()}ToJson";
        $object = Php::{$method}($this->main);
        return ESJson::fold($object);
    }

    public function jsonSerialize(): object
    {
        $method = "{$this->getType()}ToObject";
        return Php::{$method}($this->main);
    }

    public function object(): ESObject
    {
        $method = "{$this->getType()}ToObject";
        $object = Php::{$method}($this->main);
        return ESObject::fold($object);
    }

    public function string($arg): ESString
    {
        $method = "{$this->getType()}ToString";
        $string = Php::{$method}($this->main, $arg);
        return ESString::fold($string);
    }
}
