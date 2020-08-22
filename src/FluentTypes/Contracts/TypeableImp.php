<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use Eightfold\Shoop\PipeFilters;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Apply;

use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESBoolean;
use Eightfold\Shoop\FluentTypes\ESDictionary;
use Eightfold\Shoop\FluentTypes\ESInteger;
use Eightfold\Shoop\FluentTypes\ESJson;
use Eightfold\Shoop\FluentTypes\ESObject; // TODO: rename to ESTuple
use Eightfold\Shoop\FluentTypes\ESString;

trait TypeableImp
{
    public function array(): ESArray
    {
        $array = Apply::typeAsArray()->unfoldUsing($this->main);
        // $array = AsArray::apply()->unfoldUsing($this->main);
        return ESArray::fold($array);
    }

    public function boolean(): ESBoolean
    {
        $bool = AsBoolean::apply()->unfoldUsing($this->main);
        return ESBoolean::fold($bool);
    }

    public function dictionary(): ESDictionary
    {
        $array = Shoop::pipe($this->main, AsDictionary::apply());
        return ESDictionary::fold($array);
    }

    public function int(): ESInteger
    {
        return ESInteger::fold($this->count());
    }

    public function count(): int
    {
        return AsInteger::apply()->unfoldUsing($this->main);
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
        return ESObject::fold($object);
    }

    public function string($arg = ""): ESString
    {
        $string = Shoop::pipe($this->main, AsString::applyWith($arg))->unfold();
        return ESString::fold($string);
    }
}
