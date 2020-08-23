<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

// PHP 8.0 - use \Stringable as PhpStringable;

interface Stringable // extend PhpStringable
{
    public function string($arg): Stringable;

    public function efToString($arg): string;

    public function __toString(): string;
}
