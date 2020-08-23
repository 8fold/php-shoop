<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use \JsonSerializable;

trait TupleableImp
{
    // PHP 8.0 - stdClass|object
    public function efToTuple(): object
    {
        return $this->asTuple()->unfold();
    }

    public function efToJson(): string
    {
        return $this->asJson()->unfold();
    }

    public function jsonSerialize(): object // JsonSerializable
    {
        return $this->efToTuple();
    }
}
