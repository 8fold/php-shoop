<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class IsArray extends Filter
{
    private $loose = false;

    /**
     * @param bool|boolean $loose Only requires all keys to be integers, not necessarily ordered.
     */
    public function __construct(bool $loose = false)
    {
        $this->loose = $loose;
    }

    /**
     * Based on Swift Array: https://docs.swift.org/swift-book/LanguageGuide/CollectionTypes.html
     *
     * Implementation derived from: https://stackoverflow.com/questions/173400
     */
    public function __invoke($using): bool
    {
        if (! is_array($using)) return false;

        if ($using === array()) return false;

        $keys     = array_keys($using);
        $ints     = array_filter($keys, "is_integer");
        $keyCount = count($ints);

        // All keys must be integers
        $isLooseArray = $keyCount === count($using);
        if ($isLooseArray and $this->loose) return true;

        // Must be ordered.
        $rangeEnd = count($using) - 1;
        $range    = range(0, $rangeEnd);
        $keys     = array_keys($using);

        return $keys === $range;
    }
}
