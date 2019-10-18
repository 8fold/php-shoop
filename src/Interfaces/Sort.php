<?php

namespace Eightfold\Shoop\Interfaces;

interface Sort
{
    // Does not make sense on ESBool, ESInt, ESObject, ESDictionary
    public function sort($caseSensitive = true); // 7.4 : self;
}
