<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use \stdClass;

use Eightfold\Shoop\Shoop;

class IsObject extends Filter
{
    public function __invoke($using): bool
    {
        // must be an object PHP type
        if (! is_object($using)) return false;

        // must NOT be an instance of stdClass; reserved for Shoop Tuple
        if (is_a($using, stdClass::class)) return false;

        // must have methods; without this it's a strict data type - Shoop Tuple
        $methods = get_class_methods($using);

        return count($methods) > 0;
    }
}
