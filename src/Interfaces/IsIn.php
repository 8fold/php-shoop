<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESBool;

interface IsIn
{
    // isIn($hayStack, \Closure $closure = null)
    public function isIn($haystack): ESBool;
}
