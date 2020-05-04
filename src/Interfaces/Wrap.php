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

    public function startsWith(...$needles): ESBool;

    public function doesNotStartWith(...$needles): ESBool;

    public function endsWith(...$needles): ESBool;

    public function doesNotEndWith(...$needles): ESBool;
}
