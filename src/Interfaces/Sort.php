<?php

namespace Eightfold\Shoop\Interfaces;

interface Sort
{
    // Does not make sense on ESBool, ESInt, ESObject, ESDictionary
    public function sort(?string ...$flags); // 7.4 : self;
}
