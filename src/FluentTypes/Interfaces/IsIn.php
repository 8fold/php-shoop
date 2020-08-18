<?php

namespace Eightfold\Shoop\FluentTypes\Interfaces;

use \Closure;

use Eightfold\Shoop\FluentTypes\ESBool;

interface IsIn
{
    public function isIn($haystack, Closure $closure = null);

    public function isNotIn($haystack, Closure $closure = null);
}
