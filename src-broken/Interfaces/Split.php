<?php

namespace Eightfold\Shoop\Interfaces;

interface Split
{
    // Does not make sense on ESBool, ESInt (remainder of % 2),
    //      ESObject, ESDictionary
    public function split($splitter = 1, $splits = 2);
}
