<?php

namespace Eightfold\Shoop\Interfaces\ShoopedExtensions;

use Eightfold\Shoop\ESBool;

interface Compare
{
    public function is($compare);

    public function isNot($compare);

    public function isEmpty(\Closure $closure = null);

    public function isNotEmpty(\Closure $closure = null);

    public function isGreaterThan($compare, \Closure $closure = null);

    public function isGreaterThanOrEqual($compare, \Closure $closure = null);

    public function isLessThan($compare, \Closure $closure = null);

    public function isLessThanOrEqual($compare, \Closure $closure = null);
}
