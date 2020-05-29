<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESBool;

interface Compare
{
    // isGreaterThan($compare, \Closure $closure = null)
    public function isGreaterThan($compare): ESBool;

    // isGreaterThanOrEqual($compare, \Closure $closure = null)
    public function isGreaterThanOrEqual($compare): ESBool;

    // isLessThan($compare, \Closure $closure = null)
    public function isLessThan($compare): ESBool;

    // isLessThanOrEqual($compare, \Closure $closure = null)
    public function isLessThanOrEqual($compare): ESBool;
}
