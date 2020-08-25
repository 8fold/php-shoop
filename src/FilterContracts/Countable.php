<?php

namespace Eightfold\Shoop\FilterContracts;

use \Countable as PhpCountable;

use Eightfold\Shoop\FilterContracts\Countable;

interface Countable extends PhpCountable
{
    public function asInteger(): Countable;

    public function efToInteger(): int;

    public function count(): int; // Countable
}
