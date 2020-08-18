<?php

namespace Eightfold\Shoop\FluentTypes\Interfaces;

use \Closure;

use Eightfold\Shoop\FluentTypes\ESArray;

interface Each
{
    public function each(Closure $closure): ESArray;
}
