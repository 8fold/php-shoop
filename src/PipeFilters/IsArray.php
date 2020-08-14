<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class IsArray extends Filter
{
    /**
     * Derived from: https://stackoverflow.com/questions/173400
     */
    public function __invoke(array $using): bool
    {
        if ($using === array()) return false;

        $rangeEnd = count($using) - 1;
        $range    = range(0, $rangeEnd);
        $keys     = array_keys($using);

        return $keys === $range;
    }
}
