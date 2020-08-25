<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use \Countable as PhpCountable;

use Eightfold\Foldable\Foldable;

interface Countable extends PhpCountable
{
    public function asInteger(): Foldable;

    public function efToInteger(): int;

    public function count(): int; // Countable
}
