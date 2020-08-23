<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

// PHP 8.0 - use \Stringable as PhpStringable;

interface Stringable // extends PhpStringable
{
    public function asString($arg): Stringable;

    public function efToString($arg): string;

    public function __toString(): string;
}
