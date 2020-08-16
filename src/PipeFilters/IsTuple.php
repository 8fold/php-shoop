<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

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
        // covers objects and tuples
        if (! is_object($using) or is_bool($using)) return false;

        // specifically is a tuple
        if (is_a($using, \stdClass::class)) return true;

        // anonymous class without actions
        $methods = get_class_methods($using);

        return IsEmpty::apply()->unfoldUsing($methods);
    }
}
