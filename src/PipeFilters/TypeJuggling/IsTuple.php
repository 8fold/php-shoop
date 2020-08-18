<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling;

use Eightfold\Foldable\Filter;

class IsTuple extends Filter
{
    public function __invoke($using): bool
    {
        if (! is_object($using)) {
            // must be PHP object
            return false;

        } elseif (is_a($using, stdClass::class)) {
            // stdClass is reserved for Shoop Tuple
            return true;

        }

        // class without actions
        $methods = get_class_methods($using);

        return count($methods) === 0;
    }
}
