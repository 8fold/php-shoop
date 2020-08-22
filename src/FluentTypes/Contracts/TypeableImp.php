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
        return ESInteger::fold(
            $this->count()
        );
    }

    public function count(): int
    {
        return Apply::typeAsInteger()->unfoldUsing($this->main);
    }

    public function string($glue = ""): ESString
    {
        return ESString::fold(
            Apply::typeAsString($glue)->unfoldUsing($this->main)
        );
    }


    public function json(): ESJson
    {
        return ESJson::fold(
            Apply::typeAsJson()->unfoldUsing($this->main)
        );
    }

    public function jsonSerialize(): object
    {
        return Apply::typeAsTuple()->unfoldUsing($this->main);
        // die(__FILE__);
    }

    public function tuple(): ESTuple
    {
        return ESTuple::fold(
            $this->jsonSerialize()
        );
    }

    /**
     * @deprecated
     */
    public function object(): ESTuple
    {
        return $this->tuple();
    }
}
