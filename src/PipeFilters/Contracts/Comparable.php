<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use \Closure;

use Eightfold\Shoop\FluentTypes\ESBoolean;

interface Comparable
{
    public function is($compare): bool;

    public function isEmpty(): bool;

    public function isGreaterThan($compare): bool;

    public function isGreaterThanOrEqualTo($compare): bool;
}
