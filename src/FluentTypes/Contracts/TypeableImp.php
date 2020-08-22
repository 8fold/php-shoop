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
use Eightfold\Shoop\FluentTypes\ESTuple;
use Eightfold\Shoop\FluentTypes\ESString;

trait TypeableImp
{
    public function array(): ESArray
    {
        return ESArray::fold(
            Apply::typeAsArray()->unfoldUsing($this->main)
        );
    }

    public function boolean(): ESBoolean
    {
        return ESBoolean::fold(
            Apply::typeAsBoolean()->unfoldUsing($this->main)
        );
    }

    public function dictionary(): ESDictionary
    {
        return ESDictionary::fold(
            Apply::typeAsDictionary()->unfoldUsing($this->main)
        );
    }

    public function integer(): ESInteger
    {
        return ESInteger::fold($this->count());
    }

    public function string($glue = ""): ESString
    {
        $string = Apply::typeAsString($glue)->unfoldUsing($this->main);
        return ESString::fold($string);
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

    public function tuple(): ESTuple
    {
        $tuple = Apply::typeAstuple()->unfoldUsing($this->main);
        return ESTuple::fold($tuple);
    }

    /**
     * @deprecated
     */
    public function object(): ESTuple
    {
        return $this->tuple();
    }
}
