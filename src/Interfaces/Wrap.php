<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESBool;

interface Wrap
{
    // Does not make sense on ESBool, ESInt
    public function first();

    // Does not make sense on ESBool, ESInt
    public function last();

    // Does not make sense on ESBool, ESInt
    public function start(...$prefixes); // 7.4 : self;

    // Does not make sense on ESBool, ESInt
    public function end(...$suffixes); // 7.4 : self;

    // Does not make sense on ESBool, ESInt
    public function startsWith(...$needles): ESBool;

    // Does not make sense on ESBool, ESInt
    public function doesNotStartWith(...$needles): ESBool;

    // Does not make sense on ESBool, ESInt
    public function endsWith(...$needles): ESBool;

    // Does not make sense on ESBool, ESInt
    public function doesNotEndWith(...$needles): ESBool;
}
