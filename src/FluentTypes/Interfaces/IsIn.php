<?php

namespace Eightfold\Shoop\Interfaces;

use \Closure;

use Eightfold\Shoop\ESBool;

interface IsIn
{
    public function isIn($haystack, Closure $closure = null);

    public function isNotIn($haystack, Closure $closure = null);
}
