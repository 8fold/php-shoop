<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use \JsonSerializable;

use Eightfold\Foldable\Foldable;

interface Tupleable extends JsonSerializable
{
    public function asTuple(): Foldable;

    // PHP 8.0 - stdClass|object
    public function efToTuple(): object;

    public function asJson(): Foldable;

    public function efToJson(): string;

    public function jsonSerialize(): object; // JsonSerializable
}
