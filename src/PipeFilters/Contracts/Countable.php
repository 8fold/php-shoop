<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use \Countable as PhpCountable;

interface Countable extends PhpCountable
{
    public function asInteger(): Countable;

    public function efToInteger(): int;

    public function count(): int; // Countable
}
