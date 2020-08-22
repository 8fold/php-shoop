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
use Eightfold\Shoop\FluentTypes\ESTuple; // TODO: rename to ESTuple
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
        $bool = Apply::typeAsBoolean()->unfoldUsing($this->main);
        return ESBoolean::fold($bool);
    }

    public function dictionary(): ESDictionary
    {
        $array = Apply::typeAsDictionary()->unfoldUsing($this->main);
        return ESDictionary::fold($array);
    }

    public function int(): ESInteger
    {
        return ESInteger::fold($this->count());
    }

    public function count(): int
    {
        return Apply::typeAsInteger()->unfoldUsing($this->main);
    }

    public function json(): ESJson
    {
        $json = Apply::typeAsJson()->unfoldUsing($this->main);
        return ESJson::fold($json);
    }

    public function jsonSerialize(): object
    {
        $method = "{$this->getType()}ToObject";
        return Php::{$method}($this->main);
    }

    public function object(): ESTuple
    {
        $object = Shoop::pipe($this->main, AsObject::apply())->unfold();
        return ESTuple::fold($object);
    }

    public function string($arg = ""): ESString
    {
        $string = Shoop::pipe($this->main, AsString::applyWith($arg))->unfold();
        return ESString::fold($string);
    }
}
