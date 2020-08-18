<?php

namespace Eightfold\Shoop\FluentTypes\Interfaces\ShoopedExtensions;

use \Closure;

use Eightfold\Shoop\FluentTypes\ESBool;

interface Compare
{
    public function is($compare);

    public function isNot($compare);

    public function isEmpty(Closure $closure = null);

    public function isNotEmpty(Closure $closure = null);

    public function isGreaterThan($compare, Closure $closure = null);

    // TODO: Rename "isGreaterThanOrEqualTo" then deprecate
    public function isGreaterThanOrEqual($compare, Closure $closure = null);

    public function isLessThan($compare, Closure $closure = null);

    // TODO: Rename "isLessThanOrEqualTo" then deprecate
    public function isLessThanOrEqual($compare, Closure $closure = null);

    public function countIsGreaterThan($compare, Closure $closure = null);

    public function coutIsGreaterThanOrEqualTo($compare, Closure $closure = null);

    public function countIsLessThan($compare, Closure $closure = null);

    public function countIsLessThanOrEqualTo($compare, Closure $closure = null);
}
