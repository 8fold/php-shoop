<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling;

use Eightfold\Foldable\Filter;

class IsObject extends Filter
{
    public function __invoke($using): bool
    {
        if (! is_object($using)) {
            // must be an object PHP type
            return false;

        } elseif (is_a($using, stdClass::class)) {
            // must NOT be an instance of stdClass; reserved for Shoop Tuple
            return false;

        }

        // must have methods; without this it's a strict data type - Shoop Tuple
        $methods = get_class_methods($using);

        return count($methods) > 0;
    }
}
