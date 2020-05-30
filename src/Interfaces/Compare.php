<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESBool;

interface Compare
{
    public function isGreaterThan($compare, \Closure $closure = null);

    public function isGreaterThanOrEqual($compare, \Closure $closure = null);

    public function isLessThan($compare, \Closure $closure = null);

    public function isLessThanOrEqual($compare, \Closure $closure = null);
}
