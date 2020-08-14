<?php

namespace Eightfold\Shoop\Interfaces;

use \Closure;

use Eightfold\Shoop\ESArray;

interface Each
{
    public function each(Closure $closure): ESArray;
}
