<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use \JsonSerializable;

interface Tupleable extends JsonSerializable
{
    public function tuple(): Tupleable;

    public function json(): string;

    // PHP 8.0 - stdClass|object
    public function efToTuple(): object;

    public function jsonSerialize(): object; // JsonSerializable
}
