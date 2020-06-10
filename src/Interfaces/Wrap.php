<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESBool;

interface Wrap
{
    // Does not make sense on ESBool, ESInt
    public function first();

    public function last();

    public function start(...$prefixes);

    public function end(...$suffixes);

    // public function startsWith(string|array $needles, \Closure $closure = null)
    public function startsWith(...$needles);

    // public function doesNotStartWith(string|array $needles, \Closure $closure = null)
    public function doesNotStartWith(...$needles): ESBool;

    // public function endsWith(string|array $needles, \Closure $closure = null)
    public function endsWith(...$needles): ESBool;

    // public function doesNotEndWith(string|array $needles, \Closure $closure = null)
    public function doesNotEndWith(...$needles): ESBool;
}
