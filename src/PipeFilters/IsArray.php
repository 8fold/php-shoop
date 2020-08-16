<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class IsArray extends Filter
{
    /**
     * Based on Swift Array: https://docs.swift.org/swift-book/LanguageGuide/CollectionTypes.html
     *
     * Implementation derived from: https://stackoverflow.com/questions/173400
     */
    public function __invoke($using): bool
    {
        if (! is_array($using)) return false;

        if ($using === array()) return false;

        $rangeEnd = count($using) - 1;
        $range    = range(0, $rangeEnd);
        $keys     = array_keys($using);

        return $keys === $range;
    }
}
