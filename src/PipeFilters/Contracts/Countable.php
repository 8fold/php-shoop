<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use \Countable as PhpCountable;

interface Countable extends Countable, JsonSerializable
{
    public function integer(): Countable;

    public function efToInt(): int;

    public function count(): int; // Countable
}
