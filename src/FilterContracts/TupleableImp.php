<?php

namespace Eightfold\Shoop\Filter\Contracts;

use \JsonSerializable;
use \stdClass;

use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\FilterContracts\Tupleable;

trait TupleableImp
{
    // PHP 8.0 - stdClass|object
    public function efToTuple(): object
    {
        if (is_a($this, Tupleable::class) and is_a($this, Foldable::class)) {
            return $this->asTuple()->unfold();

        }
        return new stdClass;
    }

    public function efToJson(): string
    {
        if (is_a($this, Tupleable::class) and is_a($this, Foldable::class)) {
            return $this->asJson()->unfold();

        }
        return json_encode(new stdClass);
    }

    public function jsonSerialize(): object // JsonSerializable
    {
        return $this->efToTuple();
    }
}
