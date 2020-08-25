<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

// PHP 8.0 - use \Stringable as PhpStringable;

use Eightfold\Foldable\Foldable;

interface Stringable // extends PhpStringable
{
    public function asString(string $glue = ""): Foldable;

    public function efToString(string $glue = ""): string;

    public function __toString(): string;
}
