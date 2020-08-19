<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use \Closure;

use Eightfold\Shoop\FluentTypes\ESBoolean;

interface Comparable
{
    public function is($compare): ESBoolean;

    public function isNot($compare): ESBoolean;

    public function isEmpty(): ESBoolean;

    public function isNotEmpty(): ESBoolean;

    public function isGreaterThan($compare): ESBoolean;

    // TODO: Rename "isGreaterThanOrEqualTo" then deprecate
    public function isGreaterThanOrEqual($compare): ESBoolean;

    public function isLessThan($compare): ESBoolean;

    // TODO: Rename "isLessThanOrEqualTo" then deprecate
    public function isLessThanOrEqual($compare): ESBoolean;

    /**
     * @deprecated
     */
    public function countIsGreaterThan($compare): ESBoolean;

    /**
     * @deprecated
     */
    public function countIsGreaterThanOrEqualTo($compare): ESBoolean;

    /**
     * @deprecated
     */
    public function countIsLessThan($compare): ESBoolean;

    /**
     * @deprecated
     */
    public function countIsLessThanOrEqualTo($compare): ESBoolean;
}
