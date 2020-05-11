<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESArray;

interface Each
{
    public function each(\Closure $closure): ESArray;
}
