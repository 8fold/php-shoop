<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use \JsonSerializable;

interface Tupleable extends JsonSerializable
{
    public function asTuple(): Tupleable;

    public function asJson(): string;

    // PHP 8.0 - stdClass|object
    public function efToTuple(): object;

    public function jsonSerialize(): object; // JsonSerializable
}
