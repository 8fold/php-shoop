<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use \stdClass;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\IsObject;

class IsTuple extends Filter
{
    /**
     * TODO: Need to test all the type checks - type juggling is the backbone
     *
     * A Tuple MUST be an instance of stdClass - not an anonymous class.
     */
    public function __invoke($using): bool
    {
        // must be PHP object
        if (! is_object($using)) return false;

        // stdClass is reserved for Shoop Tuple
        if (is_a($using, stdClass::class)) return true;

        // class without actions
        $methods = get_class_methods($using);

        return count($methods) === 0;
    }
}
