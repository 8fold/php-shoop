<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESBool;

interface Wrap
{
    // Does not make sense on ESBool, ESInt, ESObject, ESDictionary
    public function first();

    // Does not make sense on ESBool, ESInt, ESObject, ESDictionary
    public function last();

    // Does not make sense on ESBool, ESInt, ESObject, ESDictionary
    public function start(...$prefixes); // 7.4 : self;

    // Does not make sense on ESBool, ESInt, ESObject, ESDictionary
    public function end(...$suffixes); // 7.4 : self;

    // Does not make sense on ESBool, ESInt, ESObject, ESDictionary
    public function startsWith($needle): ESBool;

    // Does not make sense on ESBool, ESInt, ESObject, ESDictionary
    public function doesNotStartWith($needle): ESBool;

    // Does not make sense on ESBool, ESInt, ESObject, ESDictionary
    public function endsWith($needle): ESBool;

    // Does not make sense on ESBool, ESInt, ESObject, ESDictionary
    public function doesNotEndWith($needle): ESBool;
}
